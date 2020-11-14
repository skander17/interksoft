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

        const update = (id) => {
            const callback =  () =>{
                window.Country.putCountry(id,getFormObject('#country-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            setFormValidation('#country-form',callback)
        };

        const create = () => {
            const callback = () => {
                window.Country.postCountry(getFormObject('#country-form')).then((request) => {
                    if (request) {
                        window.location.reload();
                    }
                });
            }

            const rules = {
                email: {
                    required: true,
                    email: true
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
            }
            setFormValidation('#country-form', callback, rules)
        };
        const cleanForm = document.getElementById("country-form").outerHTML;

        const throw_modal = async (action,country_id = null) => {
            $("#client-form").html(cleanForm);
            const save_modal = $("#save-modal")
            save_modal.off('click');
            if(action === 'create'){
                $("#exampleModalLabel").text("Crear País");
                save_modal.on('click', () => create() );
            }else{
                $("#exampleModalLabel").text("Editar País");
                if (country_id){
                    const country = await Country.getCountry(country_id);
                    fillForm(country);
                    save_modal.on('click', () =>  update(country_id) );
                }else{
                    md.shotNotification('danger',"Error al obtener el país");
                    save_modal.attr('disabled','disable');
                }
            }
        }
    </script>
@endpush
