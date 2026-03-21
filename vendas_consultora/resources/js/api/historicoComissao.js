// resources/js/api/historicoComissao.js

export const HistoricoComissaoService = {
    async getHistorico(params = {}) {
        try {
            const response = await axios.get('/api/historico-comissoes', { params });
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    }
};