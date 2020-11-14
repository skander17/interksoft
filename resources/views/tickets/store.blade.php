<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="ticket-form" action="#" class="form" novalidate="novalidate">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="ticketModalLabel"></h3>
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
                            <label for="airport_origin" class="bmd-label-floating">
                                Aeropuerto Origen
                            </label>
                            <input class="form-control typeahead" name="airport_origin" id="airport_origin" type="text"/>
                            <input class="form-control typeahead" name="airport_origin_id" id="airport_origin_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group">
                            <label for="airport_arrival" class="bmd-label-floating">
                                Aeropuerto Destino
                            </label>
                            <input class="form-control" name="airport_arrival" id="airport_arrival" type="text"/>
                            <input class="form-control typeahead" name="airport_arrival_id" id="airport_arrival_id" type="hidden"/>
                        </div>
                        <div class="col-lg-6 form-group bmd-form-group is-filled">
                            <label for="date_start" class="bmd-label-static">
                                Fecha-Hora Despegue
                            </label>
                            <input class="form-control datetimepicker" name="date_start" id="date_start" type="text"/>
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
            destination: document.getElementById("client_id"),
            keys: ['full_name']
        });

        window.typeahead.typeahead({
            element: "#airline",
            uri: "api/search/airlines",
            params: {
                search: document.getElementById("airline")
            },
            destination: document.getElementById("airline_id"),
            keys: ['name','code']
        });

        window.typeahead.typeahead({
            element: "#airport_origin",
            uri: "api/search/airports",
            params: {
                search: document.getElementById("airport_origin")
            },
            destination: document.getElementById("airport_origin_id"),
            keys: ['name','iata_code']
        });

        window.typeahead.typeahead({
            element: "#airport_arrival",
            uri: "api/search/airports",
            params: {
                search: document.getElementById("airport_arrival")
            },
            destination: document.getElementById("airport_arrival_id"),
            keys: ['name','iata_code']
        });


        let update =  (id) => {
            let rules = {}
            const callback =  (id) =>{
                window.Ticket.putTicket(id,getFormObject('#ticket-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }
            setFormValidation('#ticket-form',  callback(id),rules);
        };

        const create = () =>{
            let rules = {
                client:{
                    required: true
                },
                airline: {
                    required: true
                },
                ticket: {
                    required: true
                },
                origin_airport: {
                    required: true
                },
                arrival_airport: {
                    required: true
                },
                date_arrival: {
                    required: true
                },
                date_start: {
                    required: true
                }
            }
            const callback =  () =>{
                window.Ticket.postTicket(getFormObject('#ticket-form')).then((request)=> {
                    if (request){
                        window.location.reload();
                    }
                });
            }

            setFormValidation('#ticket-form', callback ,rules)
        };

        const throw_modal = async (action,ticket_id = null) => {
            //$("#ticket-form").trigger('reset');
            const save_modal = $("#save-ticket")
            save_modal.off('click');
            if(action === 'create'){
                $("#ticketModalLabel").text("Crear Boleto");
                save_modal.on('click', () =>  create() );
            }else{
                if (! ticket_id){
                    md.shotNotification('danger',"Error al obtener el boleto. Favor recargue a página");
                    save_modal.attr('disabled','disable');
                    return;
                }else{
                    $("#ticketModalLabel").text("Editar Boleto");
                    const ticket = await window.Ticket.getTicket(ticket_id);
                    window.Ticket.fillModel(ticket)
                    fillForm(window.Ticket.ticket);
                }
                save_modal.on('click', () => update(ticket_id) );
            }
        }
    </script>
@endpush
