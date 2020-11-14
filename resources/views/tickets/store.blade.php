<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form" id="ticket-form" novalidate="novalidate">
                <div class="modal-header">
                    <h3 class="modal-title" id="ticketModalLabel"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row mx-3">
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="client" class="bmd-label-floating">
                                Cliente
                            </label>
                            <input class="typeahead form-control" name="client" id="client" type="search"/>
                            <input class="typeahead form-control" name="client_id" id="client_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="airline" class="bmd-label-floating">
                                Aerolinea
                            </label>
                            <input class="typeahead form-control" name="airline" id="airline" type="search"/>
                            <input class="typeahead form-control" name="airline_id" id="airline_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="code" class="bmd-label-floating">
                                Código Boleto
                            </label>
                            <input class="form-control" name="code" id="code" type="text"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="ticket" class="bmd-label-floating">
                                Boleto #
                            </label>
                            <input class="form-control" name="ticket" id="ticket" type="text"/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="origin_airport" class="bmd-label-floating">
                                Aeropuerto Origen
                            </label>
                            <input class="form-control typeahead" name="origin_airport" id="origin_airport" type="text"/>
                            <input class="form-control typeahead" name="origin_airport_id" id="origin_airport_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="arrival_airport" class="bmd-label-floating">
                                Aeropuerto Destino
                            </label>
                            <input class="form-control" name="arrival_airport" id="arrival_airport" type="text"/>
                            <input class="form-control typeahead" name="arrival_airport_id" id="arrival_airport_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group is-filled">
                            <label for="date_origin" class="bmd-label-static">
                                Fecha-Hora Despegue
                            </label>
                            <input class="form-control datetimepicker" name="date_origin" id="date_origin" type="text"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group is-filled">
                            <label for="date_arrival" class="bmd-label-static">
                                Fecha-Hora Arrivo
                            </label>
                            <input class="form-control datetimepicker" name="date_arrival" id="date_arrival" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="clearfix"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info" id="save-ticket">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>

        window.typeahead.typeahead({
            element: "#client",
            uri: "api/search/clients",
            params: {
                search: document.getElementById("client")
            },
            destination: document.getElementById("client_id")
        });

        window.typeahead.typeahead({
            element: "#airline",
            uri: "api/search/airlines",
            params: {
                search: document.getElementById("airline").value
            },
            destination: document.getElementById("airline_id")
        });

        window.typeahead.typeahead({
            element: "#origin_airport",
            uri: "api/search/airports",
            params: {
                search: document.getElementById("origin_airport").value
            },
            destination: document.getElementById("origin_airport_id")
        });

        window.typeahead.typeahead({
            element: "#arrival_airport",
            uri: "api/search/airports",
            params: {
                search: document.getElementById("arrival_airport").value
            },
            destination: document.getElementById("arrival_airport_id")
        });
        const cleanForm = document.getElementById("ticket-form").outerHTML;

        let update = async (id,password = false) => {
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
            const callback = async () =>{
                const request = await window.Users.putUser(id,getFormObject('#ticket-form'));
                if (request){
                    window.location.reload();
                }
            }
            setFormValidation('#user-form', await callback,rules);
        };

        const create = async () =>{
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
            const callback = async () =>{
                const request = await window.Users.postUser(getFormObject('#ticket-form'));
                if (request){
                    window.location.reload();
                }
            }

            setFormValidation('#user-form', await callback ,rules)
        };

        const throw_modal = async (action,ticket_id = null) => {
            $("#user-form").html(cleanForm);
            const save_modal = $("#save-ticket")
            save_modal.off('click');
            if(action === 'create'){
                $("#ticketModalLabel").text("Crear Boleto");
                save_modal.on('click', async () => await create() );
            }else{
                if (! ticket_id){
                    md.shotNotification('danger',"Error al obtener el boleto. Favor recargue a página");
                    save_modal.attr('disabled','disable');
                    return;
                }else{
                    $("#ticketModalLabel").text("Editar Boleto");
                    const ticket = await window.Ticket.getTicket(ticket_id);
                    fillForm(ticket);
                }
                save_modal.on('click',async () => await update(ticket_id) );
            }
        }
    </script>
@endpush
