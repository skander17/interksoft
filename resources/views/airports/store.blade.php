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
                        <label for="country_id" class="bmd-label">
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

        const update = (id) => {
            const callback =  () =>{
                window.Airports.putAirport(id,getFormObject('#airport-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            setFormValidation('#airport-form',callback)
        };

        const create = () => {
            const callback =  () =>{
                window.Airports.postAirport(getFormObject('#airport-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            const rules = {
                name:{
                    required: true,
                },
                iata_code: {
                    required: true
                },
                country_id: {
                    required: true
                }
            }

            setFormValidation('#airport-form', callback, rules);
        }
        const cleanForm = document.getElementById("airport-form").outerHTML;

        const throw_modal = async (action,airport_id = null) => {
            $("#airport-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear Aeropuerto");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar Aeropuerto");
                if (airport_id){
                    const user = await window.Airports.getAirport(airport_id);
                    fillForm(user);
                    save_modal.on('click', () =>  update(airport_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el aeropuerto");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
