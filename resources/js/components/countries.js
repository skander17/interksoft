import api from "../helpers/api";

export default {
    country: {
        full_name: '',
        email: ''
    },
    getCountry: async function(id) {
        const response = await api.get(`/api/countries/${id}`);
        if (response.status === 200){
            return response.data.country;
        }else{
            let message = (response.data && response.data.message) || "Error al obtener el país";
            md.shotNotification('danger',message);
        }
    },
    postCountry: async function(data) {
        const response = await api.post(`/api/countries`,data);
        if (response.status === 201){
            md.setAfterReload('success',"País guardado con éxito");
            return response.data.country;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el país";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                await this.eachErrors(response.data.errors);
            }
        }
    },
    putCountry: async function(id,data) {
        const response = await api.put(`/api/countries/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"País guardado con éxito");
            return response.data.country;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el país";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteCountry: async function(id) {
        const response = await api.delete(`/api/countries/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"País eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el país";
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
