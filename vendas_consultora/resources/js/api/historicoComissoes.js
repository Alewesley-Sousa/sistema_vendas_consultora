export const HistoricoComissaoService = {

    async getHistorico() {
        try {
            const response = await axios.get('/api/comissao/historico');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },
};