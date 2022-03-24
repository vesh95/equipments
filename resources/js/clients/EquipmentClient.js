export default {
    fetchAll: () => axios.get('/api/equipment'),
    fetchById: (id) => axios.get(`/api/equipment/${id}`),
    update: (id, data) => axios.patch(`/api/equipment/${id}`, data),
    create: (data) => axios.post(`/api/equipment`, data),
    delete: (id) => axios.delete(`/api/equipment/${id}`),
}
