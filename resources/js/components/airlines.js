import api from "../helpers/api";

export default {
    airline: {
        full_name: '',
        email: ''
    },
    getAirline: async function(id) {
        const response = await api.get(`/api/airlines/${id}`);
        if (response.status === 200){
            return response.data.airline;
        }else{
            let message = (response.data && response.data.message) || "Error al obtener el aerolinea";
            md.shotNotification('danger',message);
        }
    },
    postAirline: async function(data) {
        const response = await api.post(`/api/airlines`,data);
        if (response.status === 201){
            md.setAfterReload('success',"Aerolinea guardado con éxito");
            return response.data.airline;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el aerolinea";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                await this.eachErrors(response.data.errors);
            }
        }
    },
    putAirline: async function(id,data) {
        const response = await api.put(`/api/airlines/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"Aerolinea guardado con éxito");
            return response.data.airline;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el aerolinea";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteAirline: async function(id) {
        const response = await api.delete(`/api/airlines/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"Aerolinea eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el aerolinea";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    eachErrors: function(errors) {
        for (const messages in errors ) {
            for (const message of errors[messages]) {
                md.shotNotification('warning',message);
            }
        }
    }
}
