import api from "../helpers/api";

export default {
    ticket: {
        code: '',
        ticket: '',
        client_id: -1,
        origin_airport_id: -1,
        arrival_airport_id: -1,
        airline_id: -1,
        date_start: '',
        date_arrival: ''
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
