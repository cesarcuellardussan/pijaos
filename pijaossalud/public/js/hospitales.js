var tabla;
atributosDatatable.columns = [
    {data: 'fec_creacion', name: 'fec_creacion'},
    {data: 'cod_hospital', name: 'cod_hospital'},
    {data: 'nombre', name: 'nombre'},
    {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
];
tabla = $('.data-tablehospitales').DataTable(atributosDatatable);
tabla.ajax.url("/hospitales").load();

function indexHospitales(){
    tabla.ajax.url("/hospitales").load();
}

function storeHospital(){
    let cod_hospital = $("#cod_hospital").val();
    let nombre_hospital = $("#nombre_hospital").val();
    fetch('/hospitales', {
        method: 'POST',
        body: JSON.stringify({
            cod_hospital: cod_hospital,
            nombre_hospital: nombre_hospital
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire(data.title,data.text,data.icon);
        if (data.icon == "success") {
            $("#form-create-hospital")[0].reset();
            $('#crear-hospital').modal('hide');
        }
        indexHospitales();
    })
    .catch(error => {
        console.error(error);
    });
}

function editHospital(cod_hospital){
    fetch('/hospitales/'+cod_hospital+'/edit', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        $("#cod_hospital_edit").val(data.cod_hospital);
        $("#nombre_hospital_edit").val(data.nombre);
        $("#update-hospital").data('cod-hospital',data.cod_hospital);
        $("#update-hospital").data('nombre-hospital',data.nombre);
        $('#edit-hospital').modal('show');
    })
    .catch(error => {
        console.error(error);
    });
}

function updateHospital(element){
    let cod_hospital_edit    = $("#cod_hospital_edit").val();
    let nombre_hospital_edit = $("#nombre_hospital_edit").val();
    let nombre_hospital      = $(element).data('nombre-hospital');
    let cod_hospital         = $(element).data('cod-hospital');
    alert(cod_hospital);
    fetch('/hospitales/'+cod_hospital, {
        method: 'PUT',
        body: JSON.stringify({
            cod_hospital: cod_hospital_edit,
            nombre: nombre_hospital_edit,
            nombre_hospital: nombre_hospital
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.CSRF_TOKEN
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al procesar la solicitud: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire(data.title,data.text,data.icon);
        if (data.icon == "success") {
            $('#edit-hospital').modal('hide');
        }
        indexHospitales();
    })
    .catch(error => {
        console.error(error);
    });
}

function deleteHospital(cod_hospital){

    Swal.fire({
        title: '¿Está seguro que desea eliminar el hospital?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/hospitales/'+cod_hospital, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.CSRF_TOKEN
                }
            })
            .then(response => response.json())
            .then(data => {
                indexHospitales();
                Swal.fire(data.title,data.text,data.icon);
            })
            .catch(error => {
                console.error(error);
            });
        }
    })
}
