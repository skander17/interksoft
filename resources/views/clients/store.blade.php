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
                        <label for="passport_exp" class="bmd-label">
                            Fecha Vencimiento del Pasaporte(*)
                        </label>
                        <input class="form-control datepicker" name="passport_exp" id="passport_exp" type="text"/>
                    </div>
                    <div class="bmd-form-group form-group is-filled">
                        <label for="birth_date" class="bmd-label">
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
        const update = (id) => {
            const rules = {
                passport_exp:{
                    date:true
                },
                birth_date:{
                    date:true
                }
            }
                const callback =  () =>{
                window.clients.putClient(id,getFormObject('#client-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            setFormValidation('#client-form',callback,rules)
        };

        const create = () => {
            const callback =  () =>{
                window.clients.postClient(getFormObject('#client-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            const rules = {
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
                    date:true,
                    required: true
                },
                birth_date:{
                    date:true,
                    required:true
                }
            }

            setFormValidation('#client-form', callback, rules )
        };

        const cleanForm = document.getElementById("client-form").outerHTML;

        const throw_modal = async (action,client_id = null) => {
            $("#client-form").html(cleanForm);
            $('.datepicker').daterangepicker({
                singleDatePicker: true,
                autoUpdateInput: false,
                applyButtonClasses: "btn-info",
                locale: locale_rules
            })
            $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD'));
            });
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Cliente");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar Cliente");
                if (client_id){
                    const client = await window.clients.getClient(client_id);
                    fillForm(client);
                    save_modal.on('click', () =>  update(client_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el cliente");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
