import api from "../helpers/api";

export default {
    user: {
        name: '',
        email: '',
        roles: -1
    },
    fillModel: function (response){
        this.user = {
            name: response.name,
            email: response.email,
            roles: response.roles[0].id,
        }
    },
    getUser: async function(id) {
       const response = await api.get(`/api/users/${id}`);
       if (response.status === 200){
           return response.data.user;
       }else{
           let message = (response.data && response.data.message) || "Error al obtener el usuario";
           md.shotNotification('danger',message);
       }
    },
    postUser: async function(data) {
        const response = await api.post(`/api/users`,data);
        if (response.status === 201){
            md.setAfterReload('success',"Usuario guardado con éxito");
            return response.data.user;
        }else{
            let message = (response.data && response.data.message) || "Error al guardar el usuario";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                await this.eachErrors(response.data.errors);
            }
        }
    },
    putUser: async function(id,data) {
        const response = await api.put(`/api/users/${id}`,data);
        if (response.status === 200){
            md.setAfterReload('success',"Usuario guardado con éxito");
            return response.data.user;
        }else{
            let message = (response.data && response.data.message) || "Error al editar el usuario";
            md.shotNotification('danger',message);
            if (response.data && response.data.errors){
                this.eachErrors(response.data.errors);
            }
        }
    },
    deleteUser: async function(id) {
        const response = await api.delete(`/api/users/${id}`);
        if (response.status === 206){
            md.setAfterReload('success',"Usuario eliminado con éxito");
            return response.data.message;
        }else{
            let message = (response.data && response.data.message) || "Error al borrar el usuario";
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
