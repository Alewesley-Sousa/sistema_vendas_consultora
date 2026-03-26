export const ClienteService = {
    async cadastrar(dados) {
        try {
            const response = await axios.post('/api/cliente', dados);
            return response.data;
        } catch (error) {
            // Lança o erro para ser capturado pelo componente
            throw error.response?.data || { status: 'error', messagem: 'Erro na conexão' };
        }
    }
};
