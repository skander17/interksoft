import api from "../helpers/api";

export default {
    ticket: {
        code: '',
        ticket: '',
        client_id: -1,
        client: '',
        airport_origin_id: -1,
        airport_arrival_id: -1,
        airport_origin: '',
        airport_arrival: '',
        airline_id: -1,
        airline: '',
        date_start: '',
        date_arrival: ''
    },
    fillModel: function (response){
        this.ticket = {
            code: response.code,
            ticket: response.ticket,
            client_id: response.client_id,
            client: response.client.full_name,
            airport_origin_id: response.airport_origin_id,
            airport_arrival_id: response.airport_arrival_id,
            airport_origin: response.airport_origin.name,
            airport_arrival: response.airport_arrival.name,
            airline_id: response.airline_id,
            airline: response.airline.ful_name,
            date_start: response.date_start,
            date_arrival: response.date_start
        }
    },
    eachErrors: function(errors) {
        for (const messages in errors ) {
            for (const message of errors[messages]) {
                md.shotNotification('warning',message);
            }
        }
    },
    getTicket: async function(id) {
        const response = await api.get(`/api/tickets/${id}`);
        if (response.status === 200){
            return response.data.ticket;
        }else{
            let message = (response.data && response.data.message) || "Error al obtener el ticket";
            md.shotNotification('danger',message);
        }
    },
    postTicket: async function (data) {
        const response = await api.post(`/api/tickets`,data);
        if (response.status === 201){
            md.setAfterReload('success',"Boleto guardado con éxito");
            return response.data.ticket;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el ticket";
            md.shotNotification('danger',message);
            console.log(this)
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    putTicket: async function(id,data) {
        const response = await api.put(`/api/tickets/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"Boleto guardado con éxito");
            return response.data.ticket;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el ticket";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteTicket: async function(id)  {
        const response = await api.delete(`/api/tickets/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"Boleto eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el ticket";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    }
}
