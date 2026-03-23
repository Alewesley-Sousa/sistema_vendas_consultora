export const CatalogoService = {
    async buscarCatalogos(page = 1, search = '') {
        const response = await axios.get('/api/catalogo', {
            params: { page, search }
        });
        return response.data; // Retorna { status, data: { current_page, data: [...] } }
    },

    async buscarItens(id, page = 1, search = '') {
        const response = await axios.get(`/api/catalogo/itens/${id}`, {
            params: { page, search }
        });
        return response.data;
    }
};