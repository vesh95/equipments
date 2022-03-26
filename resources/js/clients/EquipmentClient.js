export default {
    fetchAll: (options = {page: 1}) => axios.get('/api/equipment', {
        params: {
            page: options.page
        }
    }),
    fetchById: (id) => axios.get(`/api/equipment/${id}`),
    update: (id, data) => axios.patch(`/api/equipment/${id}`, data),
    create: (data) => axios.post(`/api/equipment`, data),
    delete: (id) => axios.delete(`/api/equipment/${id}`),
}
