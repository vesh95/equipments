import Index from "../components";
import EquipmentForm from "../components/EquipmentForm";
import Edit from "../components/Edit";

const routes = [
    {
        path: '/',
        component: Index,
        name: 'index',
    },
    {
        path: '/new',
        component: EquipmentForm,
        name: 'form',
    },
    {
        path: '/edit/:id',
        component: Edit,
        name: 'edit',
    }
]

export default routes;
