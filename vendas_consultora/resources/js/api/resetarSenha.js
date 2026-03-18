// resources/js/api/resetarSenha.js
export const ResetarSenhaService = {
    async enviarLink(email) {
        try {
            const response = await axios.post('/recuperar-senha', { email });
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async resetar(dados) {
        try {
            const response = await axios.post('/resetar-senha', dados);
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    }
};