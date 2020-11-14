import api from "../helpers/api";

export default {
    client: {
        full_name: '',
        email: ''
    },
    getClient: async function(id) {
        const response = await api.get(`/api/clients/${id}`);
        if (response.status === 200){
            return response.data.client;
        }else{
            let message = (response.data && response.data.message) || "Error al obtener el cliente";
            md.shotNotification('danger',message);
        }
    },
    postClient: async function(data) {
        const response = await api.post(`/api/clients`,data);
        if (response.status === 201){
            md.setAfterReload('success',"Cliente guardado con éxito");
            return response.data.client;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el cliente";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                await this.eachErrors(response.data.errors);
            }
        }
    },
    putClient: async function(id,data) {
        const response = await api.put(`/api/clients/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"Cliente guardado con éxito");
            return response.data.client;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el cliente";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteClient: async function(id) {
        const response = await api.delete(`/api/clients/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"Cliente eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el cliente";
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
