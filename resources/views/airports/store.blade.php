<div class="modal fade" id="airportModal" tabindex="-1" aria-labelledby="airportModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action id="airport-form" novalidate="novalidate">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group bmd-form-group">
                        <label for="name" class="bmd-label-floating">
                            Nombre (*)
                        </label>
                        <input class="form-control" name="name" id="name" type="text"/>
                    </div>
                    <div class="form-group bmd-form-group">
                        <label for="iata_code" class="bmd-label-floating">
                            Codigo IATA (*)
                        </label>
                        <input class="form-control" name="iata_code" id="iata_code" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="iso_region" class="bmd-label-floating">
                            ISO Region
                        </label>
                        <input class="form-control" name="iso_region" id="iso_region" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group ">
                        <label for="country" class="bmd-label">
                            País (*)
                        </label>
                        <select class="form-control" data-style="btn btn-link" id="country_id" name="country_id">
                            <option value=""></option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
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
            let message = 'Error al guardar aeropuerto';
            window.axios({
                url: `api/airports`,
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
            let message = 'Error al editar el aeropuerto';
            window.axios({
                url: `api/airports/${id}`,
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
            let callback = () => sendUpdate(id,getFormObject('#airport-form'));
            setFormValidation('#airport-form',callback)
        };

        const create = () => setFormValidation('#airport-form', () =>{
            sendCreate(getFormObject('#airport-form'));
        },{
            name:{
                required: true,
            },
            iata_code: {
                required: true
            },
            country_id: {
                required: true
            }

        });

        const getAirport = async (id) => {

            try{
                const request = window.axios({
                    url: `api/airports/${id}`,
                    method: "GET"
                });
                const response = await request;
                if (response.data.user !== undefined){
                    return response.data.user;
                }
                return {}
            }catch (e){
                console.log(e.message)
                md.shotNotification('danger',"Error al obtener el aeropuerto");
                return {};
            }
        }
        const cleanForm = document.getElementById("airport-form").outerHTML;

        const throw_modal = async (action,user_id = null) => {
            $("#airport-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Aeropuerto");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar Aeropuerto");
                if (user_id){
                    const user = await getUser(user_id);
                    fillForm(user);
                    save_modal.on('click', () =>  update(user_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el aeropuerto");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
