// resources/js/api/auth.js
export const AuthService = {
    async login(credenciais) {
        try {
            const response = await axios.post('/login', credenciais);
            
            // 1. Guardamos o token no "bolso" do navegador
            localStorage.setItem('sanctum_token', response.data.token);
            
            // 2. Avisamos o Axios para usar esse token em todas as chamadas futuras
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
            
            return response.data; // Contém a URL de redirecionamento
        } catch (error) {
            throw error.response.data;
        }
    }
};