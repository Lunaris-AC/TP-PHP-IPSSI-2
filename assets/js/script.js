document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let isValid = true;
        let errors = {};

        // Reset previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());

        // Validation functions (you can add more complex validations)
        const isNotEmpty = (value) => value.trim() !== '';
        const isValidEmail = (email) => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        };
        const isNumber = (value) => !isNaN(value) && value.trim() !== '';
        const isPasswordMatching = () => document.getElementById('mot_de_passe').value === document.getElementById('confirmation_mot_de_passe').value;
        const isLoisirsCountValid = () => {
            const loisirsSelect = document.getElementById('loisirs');
            let selectedOptionsCount = 0;
            for (let i = 0; i < loisirsSelect.options.length; i++) {
                if (loisirsSelect.options[i].selected) {
                    selectedOptionsCount++;
                }
            }
            return selectedOptionsCount >= 2 && selectedOptionsCount <= 4;
        };
        const isConsentChecked = () => document.getElementById('consentement').checked;
        const isDescriptionLengthValid = () => document.getElementById('description').value.length <= 978;


        // --- Field Validations ---

        // Nom
        if (!isNotEmpty(document.getElementById('nom').value)) {
            errors['nom'] = 'Le nom est obligatoire.';
        }
        // Prenom
        if (!isNotEmpty(document.getElementById('prenom').value)) {
            errors['prenom'] = 'Le prénom est obligatoire.';
        }
        // Email
        if (!isNotEmpty(document.getElementById('email').value) || !isValidEmail(document.getElementById('email').value)) {
            errors['email'] = 'L\'email est obligatoire et doit être valide.';
        }
        // Age
        if (!isNotEmpty(document.getElementById('age').value) || !isNumber(document.getElementById('age').value)) {
            errors['age'] = 'L\'âge est obligatoire et doit être un nombre.';
        }
        // Sexe
        if (!document.querySelector('input[name="sexe"]:checked')) {
            errors['sexe'] = 'Le sexe est obligatoire.';
        }
        // Adresse
        if (!isNotEmpty(document.getElementById('adresse_numero').value)) errors['adresse_numero'] = 'Le numéro de rue est obligatoire.';
        if (!isNotEmpty(document.getElementById('adresse_rue').value)) errors['adresse_rue'] = 'Le nom de rue est obligatoire.';
        if (!isNotEmpty(document.getElementById('adresse_zip').value)) errors['adresse_zip'] = 'Le code postal est obligatoire.';
        
        if (!isNotEmpty(document.getElementById('adresse_ville').value)) errors['adresse_ville'] = 'La ville est obligatoire.';

        // Nationalite
        if (!isNotEmpty(document.getElementById('nationalite').value)) {
            errors['nationalite'] = 'La nationalité est obligatoire.';
        }
        // Pays de naissance
        if (!isNotEmpty(document.getElementById('pays_naissance').value)) {
            errors['pays_naissance'] = 'Le pays de naissance est obligatoire.';
        }
        // Mot de passe
        if (!isNotEmpty(document.getElementById('mot_de_passe').value)) {
            errors['mot_de_passe'] = 'Le mot de passe est obligatoire.';
        }
        // Confirmation mot de passe
        if (!isNotEmpty(document.getElementById('confirmation_mot_de_passe').value)) {
            errors['confirmation_mot_de_passe'] = 'La confirmation du mot de passe est obligatoire.';
        } else if (!isPasswordMatching()) {
            errors['confirmation_mot_de_passe'] = 'Les mots de passe ne correspondent pas.';
        }
        // Loisirs
        if (!isLoisirsCountValid()) {
            errors['loisirs'] = 'Veuillez sélectionner entre 2 et 4 loisirs.';
        }
        // Consentement
        if (!isConsentChecked()) {
            errors['consentement'] = 'Le consentement est obligatoire.';
        }
        // Description
        if (!isDescriptionLengthValid()) {
            errors['description'] = 'La description ne doit pas dépasser 978 caractères.';
        }


        // --- Display Errors and Prevent Submit ---
        for (const fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                isValid = false;
                const errorElement = document.createElement('p');
                errorElement.classList.add('text-red-500', 'text-xs', 'italic', 'font-semibold', 'error-message');
                errorElement.textContent = errors[fieldName];

                const fieldElement = document.getElementById(fieldName);
                if (fieldName === 'sexe') { // For radio buttons, append error after the sexe fieldset/div
                    fieldElement.closest('.mb-4').appendChild(errorElement); // Assuming sexe radios are in a div with mb-4 class. Adjust if needed.
                } else if (fieldName === 'loisirs') { // For multiselect, append error after the select
                    fieldElement.closest('.mb-4').appendChild(errorElement);
                } else if (fieldName.startsWith('adresse_')) { // For address fields, append error after the address block
                    fieldElement.closest('.mb-4').appendChild(errorElement); // Assuming address inputs are grouped in a div with mb-4 class. Adjust if needed.
                }
                else {
                    fieldElement.parentNode.insertBefore(errorElement, fieldElement.nextSibling);
                }
            }
        }


        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    });
});