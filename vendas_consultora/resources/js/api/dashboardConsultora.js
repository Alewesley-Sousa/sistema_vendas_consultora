export const DashboardConsultoraService = {
    async getMeta() {
        try {
            const response = await axios.get('/api/meta');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async getComissao() {
        try {
            const response = await axios.get('/api/comissao');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async getProgresso() {
        try {
            const response = await axios.get('/api/meta/progresso');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    }
};