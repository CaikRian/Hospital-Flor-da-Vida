
// Calcula a data máxima como 18 anos atrás da data atual
const hoje = new Date();
const ano = hoje.getFullYear() - 18; // mínimo de 18 anos
const mes = ('0' + (hoje.getMonth() + 1)).slice(-2); // Adiciona zero à esquerda para garantir 2 dígitos
const dia = ('0' + hoje.getDate()).slice(-2);
const dataMaxima = `${ano}-${mes}-${dia}`;

document.getElementById('data_nascimento').setAttribute('max', dataMaxima);

document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    function mascaraCPF(valor) {
        valor = valor.replace(/\D/g, ''); // Remove tudo o que não é dígito
        if (valor.length > 11) valor = valor.slice(0, 11); // Limita o número de dígitos
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
        return valor;
    }

    // Máscara para Telefone
    function mascaraTelefone(valor) {
        valor = valor.replace(/\D/g, ''); // Remove tudo o que não é dígito
        if (valor.length > 11) valor = valor.slice(0, 11); // Limita o número de dígitos
        valor = valor.replace(/^(\d{2})(\d)/, '($1) $2'); // Adiciona o parêntese e espaço
        valor = valor.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen
        return valor;
    }

    // Máscara para CEP
    function mascaraCEP(valor) {
        valor = valor.replace(/\D/g, ''); // Remove tudo o que não é dígito
        if (valor.length > 8) valor = valor.slice(0, 8); // Limita o número de dígitos
        valor = valor.replace(/(\d{5})(\d{0,3})$/, '$1-$2'); // Adiciona o hífen
        return valor;
    }

    // Aplicar máscaras aos campos
    const cpfInput = document.getElementById('cpf');
    const telefoneInput = document.getElementById('telefone');
    const cepInput = document.getElementById('cep');

    cpfInput.addEventListener('input', function(event) {
        event.target.value = mascaraCPF(event.target.value);
    });

    telefoneInput.addEventListener('input', function(event) {
        event.target.value = mascaraTelefone(event.target.value);
    });

    cepInput.addEventListener('input', function(event) {
        event.target.value = mascaraCEP(event.target.value);
    });

    // Validação dos campos
    function validarCampo(input, comprimento) {
        input.addEventListener('blur', function(event) {
            if (event.target.value.replace(/\D/g, '').length !== comprimento) {
                event.target.classList.add('is-invalid');
            } else {
                event.target.classList.remove('is-invalid');
            }
        });
    }

    validarCampo(cpfInput, 11); // CPF deve ter 11 dígitos numéricos
    validarCampo(telefoneInput, 11); // Telefone deve ter 11 dígitos numéricos
    validarCampo(cepInput, 8); // CEP deve ter 8 dígitos numéricos
});
