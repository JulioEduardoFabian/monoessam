import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

export function useStaffForm() {
    const form = useForm({
        name: '',
        dni: '',
        cell: '',
        birthdate: '',
        age: 0,
        sex: 0,
        email: '',
        country: '',
        civilstatus: 0,
        contactname: '',
        contactcell: '',
        cafeId: null,
        files: [],
        tipoContrato: '',
        regimenLaboral: '',
        fechaIngreso: '',
        fechaFinContract: '',
        cc: '',
        cci: '',
        children: 0,
        prendas: [],
        district: '',
        province: '',
        department: '',
        afp: '',
        onp: '',
        position: '',
        address: '',
        workSystem: '',
        replacement: '',
        unitId: 0,
        salary: 0.0,
        observations: '',
        fondo: 0,
        roleId: null,
        unitSelectedText: '',
        filesData: [],
    });

    const errorsSend = ref([]);
    const showErrors = ref(false);

    const prendasFijas = ref([
        { label: 'Polo', talla: '' },
        { label: 'Cafarena', talla: '' },
        { label: 'Overall', talla: '' },
        { label: 'Casaca', talla: '' },
        { label: 'Chaleco', talla: '' },
        { label: 'Chaqueta Blanca', talla: '' },
        { label: 'Pantalón', talla: '' },
        { label: 'Camisa/Blusa', talla: '' },
        { label: 'Guardapolvo', talla: '' },
        { label: 'Guantes', talla: '' },
        { label: 'Botas Blancas', talla: '' },
        { label: 'Zapatos', talla: '' },
        { label: 'Lentes', talla: '' },
    ]);

    const handleSubmit = (onSuccess: () => void, filesReq: any) => {
        // Convertir a array primero (maneja Proxy, Ref, y arrays normales)
        let filesArray;

        if (Array.isArray(filesReq)) {
            filesArray = filesReq;
        } else if (filesReq && typeof filesReq === 'object') {
            // Si es un Proxy o tiene una propiedad value (Ref)
            filesArray = Array.isArray(filesReq.value) ? filesReq.value : Object.values(filesReq);
        } else {
            filesArray = [];
        }

        console.log('filesArray:', filesArray);

        // Extraer solo los objetos File del array
        const validFiles = filesArray
            .filter((item: any) => item && typeof item === 'object')
            .map((item: any) => item.file)
            .filter((file: any) => file instanceof File);

        console.log('Archivos válidos a subir:', validFiles.length, validFiles);

        if (validFiles.length === 0) {
            console.error('No hay archivos válidos para subir');
            showErrors.value = true;
            errorsSend.value = { files: ['No hay archivos seleccionados'] };
            return;
        }

        form.prendas = prendasFijas.value;
        form.files = validFiles;

        form.post(route('staff.store'), {
            forceFormData: true,
            preserveState: true,
            onSuccess: (res) => {
                form.reset();
                onSuccess();
            },
            onError: (errors) => {
                showErrors.value = true;
                errorsSend.value = errors;
                console.error('Error al subir el archivo:', errors);
            },
        });
    };

    const selectCafe = (cafe: any) => {
        form.cafeId = cafe.id;
        form.unitId = cafe.unit_id;
        form.unitSelectedText = cafe.unit.name;
    };

    const selectRole = (role: any) => {
        form.roleId = role.id;
    };

    return {
        form,
        errorsSend,
        showErrors,
        prendasFijas,
        handleSubmit,
        selectCafe,
        selectRole,
    };
}
