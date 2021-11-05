import custom_axios from '../pluggins/axios'

export default {
    get:  async (uri,params) => {
        try{
            return await custom_axios.get(uri,params);
        }catch (e){
            console.log(e);
            return e.response || {status:0,message:"No hay conexión con el servidor"}
        }
    },
    post: async (uri,data) => {
        try{
            return await custom_axios.post(uri,data);
        }catch (e){
            console.log(e);
            return e.response || {status:0,data:{message:"No hay conexión con el servidor"}}
        }
    },
    put: async (uri,data) => {
        try{
            return await  custom_axios.put(uri,data);
        }catch (e){
            console.log(e);
            return e.response || {status:0,message:"No hay conexión con el servidor"}
        }
    },
    delete: async (uri) => {
        try{
            return await  custom_axios.delete(uri);
        }catch (e){
            console.log(e);
            return e.response || {status:0,message:"No hay conexión con el servidor"}
        }
    }
}
