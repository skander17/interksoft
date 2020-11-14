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
@endpush
<script>

    const update = (id) => {
        const callback =  () =>{
            window.Airline.putAirline(id,getFormObject('#airline-form')).then((request)=> {
                if (request){
                    window.location.reload();
                }
            });
        }
        setFormValidation('#airline-form',callback)
    };

    const create = () => {
        const callback =  () =>{
            window.Airline.postAirline(getFormObject('#airline-form')).then((request)=> {
                if (request){
                    window.location.reload();
                }
            });
        }
        setFormValidation('#airline-form', callback(), {
            ful_name: {
                required: true
            }
        })
    };

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
                const user = await window.Airline.getAirline(airline_id);
                fillForm(user);
                save_modal.on('click', () =>  update(airline_id) );
            }else{
                md.shotNotification('danger',"Error al obtener la aerolinea");
                save_modal.attr('disabled','disable');
            }
        }
    }
</script>
