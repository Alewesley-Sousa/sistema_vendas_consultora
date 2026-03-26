export const DashboardService = {
    async getStats() {
        const [resComissao, resMeta, resProgresso] = await Promise.all([
            axios.get('/api/comissao'),
            axios.get('/api/meta'),
            axios.get('/api/meta/progresso')
        ]);

        return {
            comissao: resComissao.data.data || 0,
            meta: resMeta.data.data || 0,
            progresso: parseFloat(resProgresso.data.data || 0)
        };
    },
    async solicitarSaque() {
        const response = await axios.get('/api/comissao/solicitar');
        return response.data;
    }
};