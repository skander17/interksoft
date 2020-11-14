<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action id="client-form" novalidate="novalidate">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group bmd-form-group">
                        <label for="full_name" class="bmd-label-floating">
                            Nombre Completo (*)
                        </label>
                        <input class="form-control" name="full_name" id="full_name" type="text"/>
                    </div>
                    <div class="form-group bmd-form-group">
                        <label for="dni" class="bmd-label-floating">
                            DNI (*)
                        </label>
                        <input class="form-control" name="dni" id="dni" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="email" class="bmd-label-floating">
                            Email (*)
                        </label>
                        <input class="form-control" name="email" id="email" type="email"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="phone" class="bmd-label-floating">
                            Telefono
                        </label>
                        <input class="form-control" name="phone" id="phone" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="passport" class="bmd-label-floating">
                            Pasaporte (*)
                        </label>
                        <input class="form-control" name="passport" id="passport" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group is-filled">
                        <label for="passport_exp" class="bmd-label-floating">
                            Fecha Vencimiento del Pasaporte(*)
                        </label>
                        <input class="form-control datepicker" name="passport_exp" id="passport_exp" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group is-filled">
                        <label for="birth_date" class="bmd-label-floating">
                            Fecha de Nacimiento
                        </label>
                        <input class="form-control datepicker" name="birth_date" id="birth_date" type="text"/>
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
            let message = 'Error al guardar cliente';
            window.axios({
                url: `api/clients`,
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
            let message = 'Error al editar el cliente';
            window.axios({
                url: `api/clients/${id}`,
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
            let callback = () => sendUpdate(id,getFormObject('#client-form'));
            setFormValidation('#client-form',callback)
        };



        const create = () => setFormValidation('#client-form', () =>{
            sendCreate(getFormObject('#client-form'));
        },{
            full_name:{
                required: true,
            },
            dni: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            passport:{
                required:true
            },
            passport_exp:{
                required: true
            },
            birth_date:{
                required:true
            }

        });

        const getUser = async (id) => {

            try{
                const request = window.axios({
                    url: `api/clients/${id}`,
                    method: "GET"
                });
                const response = await request;
                if (response.data.client !== undefined){
                    return response.data.client;
                }
                return {}
            }catch (e){
                console.log(e.message)
                md.shotNotification('danger',"Error al obtener el cliente");
                return {};
            }
        }
        const cleanForm = document.getElementById("client-form").outerHTML;

        const throw_modal = async (action,user_id = null) => {
            $("#client-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Cliente");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar Cliente");
                if (user_id){
                    const user = await getUser(user_id);
                    fillForm(user);
                    save_modal.on('click', () =>  update(user_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el cliente");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
