import Index from "../components";
import EquipmentForm from "../components/EquipmentForm";

const routes = [
    {
        path: '/',
        component: Index,
        name: 'index'
    },
    {
        path: '/new',
        component: EquipmentForm,
        name: 'form'
    }
]

export default routes;
