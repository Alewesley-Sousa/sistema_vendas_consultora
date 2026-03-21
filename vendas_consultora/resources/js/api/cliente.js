export const ClienteService = {
    // Busca dados para edição
    async getCliente(id) {
        try {
            const response = await axios.get(`/api/cliente/${id}`);
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    },

    // Salva novo ou atualiza existente
    async salvar(dados, id = null) {
        try {
            const url = id ? `/api/cliente/${id}` : '/api/cliente';
            const metodo = id ? 'put' : 'post';
            const response = await axios[metodo](url, dados);
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    }
};