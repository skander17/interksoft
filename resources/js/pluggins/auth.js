import api from './axios'

export default {
    checkToken : async () => {
        try{
            const response = await api.get('auth/jwt')
            if (response.status === 200 && response.data.access_token){
                localStorage.setItem('token',response.data.access_token);
            }

        }catch (e){
            localStorage.removeItem('token');
        }
    }
}
