<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" id="user-form" novalidate="novalidate">
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
                        Nombre Completo
                    </label>
                    <input class="form-control" name="name" id="name" type="text"/>
                </div>
                <div class="bmd-form-group form-group">
                    <label for="email" class="bmd-label-floating">
                        Email (*)
                    </label>
                    <input class="form-control" name="email" id="email" type="email"/>
                </div>
                <div class="bmd-form-group form-group">
                    <label for="password" class="bmd-label-floating">
                        Contraseña (*)
                    </label>
                    <input class="form-control" name="password" id="password" type="password"/>
                </div>
                <div class="bmd-form-group form-group">
                    <label for="password_confirmation" class="bmd-label-floating">
                        Confirmar Contraseña (*)
                    </label>
                    <input class="form-control" name="password_confirmation"
                           id="password_confirmation" type="password"  />
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info" id="save-user">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>

        const getUser =  async (id) => {

            try{
                const request = window.axios({
                    url: `api/users/${id}`,
                    method: "GET"
                });
                const response = await request;
                if (response.data.user !== undefined){
                    return response.data.user;
                }
                return {}
            }catch (e){
                console.log(e.message)
                md.shotNotification('danger',"Error al obtener el usuario");
                return {};
            }
        }


        const sendCreate = (data) => {
            let message = 'Error al guardar usuarios';
            window.axios({
                url: `api/users/`,
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

            let message = 'Error al editar el usuario';
            window.axios({
                url: `api/users/${id}`,
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


        let update = (id,password = false) => {
            console.log('id clicked');
            console.log(id);
            let rules = {}
            if (password){
                rules = {
                    password: {
                        required: true,
                            minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                            minlength: 8,
                            equalTo: "#password"
                    }
                }
            }
            setFormValidation('#user-form',() =>{
                sendUpdate(id,getFormObject('#user-form'))
            });
        };

        const create = () => setFormValidation('#user-form', () =>{
            sendCreate(getFormObject('#user-form'));
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
                equalTo: "#password"
            }

        });
        const cleanForm = document.getElementById("user-form").outerHTML;
        const throw_modal = async (action,user_id = null) => {
            $("#user-form").html(cleanForm);
            const save_modal = $("#save-user")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Usuario");
                save_modal.on('click',() =>  create() );
            }else{
                if (! user_id){
                    md.shotNotification('danger',"Error al obtener el usuario. Favor recargue a página");
                    save_modal.attr('disabled','disable');
                    return;
                }
                let password = false;
                if (action === 'password'){
                    $("#exampleModalLabel").text("Editar Contraseña");
                    $('#email').closest(".form-group").remove();
                    $('#name').closest(".form-group").remove();
                    password = true;
                }else{
                    $("#exampleModalLabel").text("Editar Usuario");
                    $('#password').closest(".form-group").remove();
                    $('#password_confirmation').closest(".form-group").remove();
                    const user = await getUser(user_id);
                    fillForm(user);
                }
                save_modal.on('click',() => update(user_id,password) );
            }
        }
    </script>
@endpush
