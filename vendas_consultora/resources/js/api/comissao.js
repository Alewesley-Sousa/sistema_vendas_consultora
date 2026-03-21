// resources/js/api/comissao.js

export const ComissaoService = {
    // pega o historico de comissoes
    async getHistorico(params = {}) {
        try {
            const response = await axios.get('/api/comissao/historico', { params });
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    },

    // metodo para solicitar o saque
    async solicitarSaque() {
        try {
            const response = await axios.get('/api/comissao/solicitar');
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    }
};