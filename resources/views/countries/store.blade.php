<div class="modal fade" id="countryModal" tabindex="-1" aria-labelledby="countryModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action id="country-form" novalidate="novalidate">
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
                        <label for="code" class="bmd-label-floating">
                            Código ISO (*)
                        </label>
                        <input class="form-control" name="code" id="code" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group">
                        <label for="continent_code" class="bmd-label-floating">
                            Código Contienente
                        </label>
                        <input class="form-control" name="continentcon_code" id="continent_code" type="email"/>
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
            let message = 'Error al guardar país';
            window.axios({
                url: `api/countries`,
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
            let message = 'Error al editar el país';
            window.axios({
                url: `api/countries/${id}`,
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
            let callback = () => sendUpdate(id,getFormObject('#country-form'));
            setFormValidation('#country-form',callback)
        };

        const create = () => setFormValidation('#country-form', () =>{
            sendCreate(getFormObject('#country-form'));
        },{
            email:{
                required: true,
                email:true
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "password"
            }

        });

        const getUser = async (id) => {

            try{
                const request = window.axios({
                    url: `api/countries/${id}`,
                    method: "GET"
                });
                const response = await request;
                if (response.data.user !== undefined){
                    return response.data.user;
                }
                return {}
            }catch (e){
                console.log(e.message)
                md.shotNotification('danger',"Error al obtener el país");
                return {};
            }
        }
        const cleanForm = document.getElementById("country-form").outerHTML;

        const throw_modal = async (action,user_id = null) => {
            $("#client-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear País");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar País");
                if (user_id){
                    const user = await getUser(user_id);
                    fillForm(user);
                    save_modal.on('click', () =>  update(user_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el país");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
