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
                <div class="bmd-form-group form-group is-filled">
                    <label for="roles" class="bmd-label-floating">
                        Roles (*)
                    </label>
                    <select class="form-control" data-style="btn btn-link" id="roles" name="roles">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
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
        const cleanForm = document.getElementById("user-form").outerHTML;

        let update =  (id,password = false) => {
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
            const callback =  () =>{
                window.Users.putUser(id,getFormObject('#user-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            setFormValidation('#user-form', callback,rules);
        };

        const create = () =>{
            let rules = {
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
            }
            const callback =  () =>{
                window.Users.postUser(getFormObject('#user-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }

            setFormValidation('#user-form', callback ,rules)
        };

        const throw_modal = async (action,user_id = null) => {
            $("#user-form").html(cleanForm);
            const save_modal = $("#save-user")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Usuario");
                save_modal.on('click', () => create() );
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
                    $('#roles').closest(".form-group").remove();
                    password = true;
                }else{
                    $("#exampleModalLabel").text("Editar Usuario");
                    $('#password').closest(".form-group").remove();
                    $('#password_confirmation').closest(".form-group").remove();
                    const user = await window.Users.getUser(user_id);
                    console.log(user);
                    fillForm(user);
                }
                save_modal.on('click', () => update(user_id,password) );
            }
        }
    </script>
@endpush
