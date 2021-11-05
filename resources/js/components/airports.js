import api from "../helpers/api";

export default {
    airport: {
        full_name: '',
        email: ''
    },
    getAirport: async function(id) {
        const response = await api.get(`/api/airports/${id}`);
        if (response.status === 200){
            return response.data.airport;
        }else{
            let message = (response.data && response.data.message) || "Error al obtener el aeropuerto";
            md.shotNotification('danger',message);
        }
    },
    postAirport: async function(data) {
        const response = await api.post(`/api/airports`,data);
        if (response.status === 201){
            md.setAfterReload('success',"Aeropuerto guardado con éxito");
            return response.data.airport;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el aeropuerto";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                await this.eachErrors(response.data.errors);
            }
        }
    },
    putAirport: async function(id,data) {
        const response = await api.put(`/api/airports/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"Aeropuerto editado con éxito");
            return response.data.airport;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el aeropuerto";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteAirport: async function(id) {
        const response = await api.delete(`/api/airports/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"Aeropuerto eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el aeropuerto";
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
