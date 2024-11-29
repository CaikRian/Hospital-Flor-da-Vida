
document.addEventListener('DOMContentLoaded', function () {
    
    // Máscara de CPF
    document.getElementById('cpf_paciente').addEventListener('input', function(e) {
        let cpf = e.target.value.replace(/\D/g, '');
        if (cpf.length <= 11) {
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');
        }
        e.target.value = cpf;
    });

    const btnPaciente = document.getElementById('btn-paciente');
    const btnMedico = document.getElementById('btn-medico');
    const btnAdmin = document.getElementById('btn-admin');
    const formPaciente = document.getElementById('form-paciente');
    const formMedico = document.getElementById('form-medico');
    const formAdmin = document.getElementById('form-admin');

    // Exibir o formulário de paciente por padrão
    formPaciente.classList.add('active');
    btnPaciente.classList.remove('btn-secondary');
    btnPaciente.classList.add('btn-primary');

    btnPaciente.addEventListener('click', () => {
        formPaciente.classList.add('active');
        formMedico.classList.remove('active');
        formAdmin.classList.remove('active');
        btnPaciente.classList.remove('btn-secondary');
        btnPaciente.classList.add('btn-primary');
        btnMedico.classList.remove('btn-primary');
        btnMedico.classList.add('btn-secondary');
        btnAdmin.classList.remove('btn-primary');
        btnAdmin.classList.add('btn-secondary');
    });

    btnMedico.addEventListener('click', () => {
        formMedico.classList.add('active');
        formPaciente.classList.remove('active');
        formAdmin.classList.remove('active');
        btnMedico.classList.remove('btn-secondary');
        btnMedico.classList.add('btn-primary');
        btnPaciente.classList.remove('btn-primary');
        btnPaciente.classList.add('btn-secondary');
        btnAdmin.classList.remove('btn-primary');
        btnAdmin.classList.add('btn-secondary');
    });

    btnAdmin.addEventListener('click', () => {
        formAdmin.classList.add('active');
        formPaciente.classList.remove('active');
        formMedico.classList.remove('active');
        btnAdmin.classList.remove('btn-secondary');
        btnAdmin.classList.add('btn-primary');
        btnPaciente.classList.remove('btn-primary');
        btnPaciente.classList.add('btn-secondary');
        btnMedico.classList.remove('btn-primary');
        btnMedico.classList.add('btn-secondary');
    });
});
