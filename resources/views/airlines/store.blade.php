<div class="modal fade" id="airlineModal" tabindex="-1" aria-labelledby="airlineModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action id="airline-form" novalidate="novalidate">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group bmd-form-group">
                        <label for="ful_name" class="bmd-label-floating">
                            Nombre Completo (*)
                        </label>
                        <input class="form-control" name="ful_name" id="ful_name" type="text"/>
                    </div>
                    <div class="form-group bmd-form-group">
                        <label for="description" class="bmd-label-floating">
                            Descripción
                        </label>
                        <input class="form-control" name="description" id="description" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="code" class="bmd-label-floating">
                            Codigo
                        </label>
                        <input class="form-control" name="code" id="code" type="text"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info" id="save-modal">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>
        const sendCreate = (data) => {
            let message = 'Error al guardar la aerolinea';
            window.axios({
                url: `api/airlines/`,
                method: "POST",
                data: data
            }).then(async (result) => {
                if(result.data.message !== undefined){
                    message = result.data.message;
                }
                if (result.status === 201){
                    md.setAfterReload('success',message)
                    window.location.reload();
                }else{
                    md.shotNotification('danger',message)
                }
            }).catch((error) => {
                md.shotNotification('danger',message)

                if (error.response.data.errors !== undefined){
                    for (const messages in error.response.data.errors ) {
                        for (const message of  error.response.data.errors[messages]) {
                            md.shotNotification('warning',message);
                        }
                    }
                }
            });
        }

        const sendUpdate = (id, data) => {
            let message = 'Error al editar la aerolinea';
            window.axios({
                url: `api/airlines/${id}`,
                method: "PUT",
                data: data
            }).then(async (result) => {
                if(result.data.message !== undefined){
                    message = result.data.message;
                }
                if (result.status === 200){
                    md.setAfterReload('success',message)
                    window.location.reload();
                }else{
                    md.shotNotification('danger',message)
                }
            }).catch((error) => {
                md.shotNotification('danger',message)

                if (error.response.data.errors !== undefined){
                    for (const messages in error.response.data.errors ) {
                        for (const message of  error.response.data.errors[messages]) {
                            md.shotNotification('warning',message);
                        }
                    }
                }
            });
        }

        const fillForm = (object) =>{
            for (const key in object) {
                let input = $("#"+key);
                if (input.length){
                    input.attr('value',object[key]);
                    input.closest('.form-group').addClass('is-filled')
                }
            }
        };


        const update = (id) => {
            let callback = () => sendUpdate(id,getFormObject('#airline-form'));
            setFormValidation('#airline-form',callback)
        };

        const create = () => setFormValidation('#airline-form', () =>{
            sendCreate(getFormObject('#airline-form'));
        },{
                ful_name: {
                    required: true
                }
        });

        const getAirline = async (id) => {

            try{
                const request = window.axios({
                    url: `api/airlines/${id}`,
                    method: "GET"
                });
                const response = await request;
                if (response.data.airline !== undefined){
                    return response.data.airline;
                }
                return {}
            }catch (e){
                console.log(e.message)
                md.shotNotification('danger',"Error al obtener la aerolinea");
                return {};
            }
        }
        const cleanForm = document.getElementById("airline-form").outerHTML;

        const throw_modal = async (action,airline_id = null) => {
            $("#airline-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Aerolinea");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar Aerolinea");
                if (airline_id){
                    const user = await getAirline(airline_id);
                    fillForm(user);
                    save_modal.on('click', () =>  update(airline_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener la aerolinea");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
