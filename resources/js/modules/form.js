const form = document.querySelector('form#self_ass_form');
const fieldsets = form ? form.querySelectorAll('fieldset') : undefined;
const url = '/form';
const token = document.querySelector('input[name=_token]').value;
const redirect = '/form'
const nextButton = form ? form.querySelector('[data-js-next]') : undefined;
const prevButton = form ? form.querySelector('[data-js-prev]') : undefined;
const confirmButton = form ? form.querySelector('[data-js-confirm-button]') : undefined;
const progressBar = form ? form.querySelector('[data-js-progress]') : undefined;
const confirmModal = form ? form.querySelector('[data-js-confirm') : undefined;
const submitButton = form ? form.querySelector('[data-js-submit') : undefined;
const cancelButton = form ? form.querySelector('[data-js-cancel-confirmation') : undefined;
let result = [];

if (form) {

    function setProgressStatus() {
        const total = fieldsets.length;
        const index = Array.from(fieldsets).map(x => x.className).indexOf('active') + 1;
        const width = index * 100 / total;
        progressBar.style.width = `${width}%`;
    }

    function getActiveFieldset() {
        return Array.from(fieldsets).filter(fieldset => fieldset.classList.contains('active'));
    }

    function getNextElement(activeFieldset) {
        if (!activeFieldset) {
            activeFieldset = getActiveFieldset()[0];
        }
        return activeFieldset.nextElementSibling;
    }

    function getPrevElement(activeFieldset) {
        if (!activeFieldset) {
            activeFieldset = getActiveFieldset()[0];
        }
        return activeFieldset.previousElementSibling;
    }

    function getInputGroupsFromActiveFieldset(fieldset) {
        return fieldset[0].querySelectorAll('.checkbox-group');
    }

    function isAnswered(group) {
        return Array.from(group.querySelectorAll('input')).some(input => input.checked);
    }

    function isCategoryAnswered(groups) {
        let answered = false;
        for (let index = 0; index < groups.length; index++) {
            const group = groups[index];
            if (!Array.from(group.querySelectorAll('input')).some(input => input.checked)) {
                answered = false;
                break;
            } else {
                answered = true;
            }
        }
        return answered;
    }

    function scrollToTop() {
        const activeFieldset = getActiveFieldset()[0];
        activeFieldset.scrollIntoView({ block: "start", behavior: "smooth" });
    }

    function showNextFieldset() {
        const activeFieldset = getActiveFieldset()[0];
        const nextFieldset = getNextElement(activeFieldset);
        activeFieldset.classList.remove('active');
        activeFieldset.classList.add('hidden');
        nextFieldset.classList.add('active');
        nextFieldset.classList.remove('hidden');
        scrollToTop();
    }

    function showPrevFieldset() {
        const activeFieldset = getActiveFieldset()[0];
        const prevFieldset = getPrevElement(activeFieldset);
        activeFieldset.classList.remove('active');
        activeFieldset.classList.add('hidden');
        prevFieldset.classList.add('active');
        prevFieldset.classList.remove('hidden');
        scrollToTop();
    }

    function hasFollowingFieldset() {
        return getNextElement().nodeName === 'FIELDSET';
    }

    function hasPreviousFieldset() {
        return getPrevElement().nodeName === 'FIELDSET';
    }

    function initValidation() {
        let activeFieldset = getActiveFieldset();
        let inputGroups = getInputGroupsFromActiveFieldset(activeFieldset);

        prevButton.setAttribute('disabled', true);
        nextButton.setAttribute('disabled', true);
        confirmButton.setAttribute('disabled', true);

        if (!hasFollowingFieldset()) {
            confirmButton.classList.remove('hidden');
            nextButton.classList.add('hidden');
        } else {
            confirmButton.classList.add('hidden');
            nextButton.classList.remove('hidden');
        }

        if (hasPreviousFieldset()) {
            prevButton.removeAttribute('disabled');
        }

        inputGroups.forEach(group => {
            if (isAnswered(group)) {
                if (isCategoryAnswered(inputGroups)) {
                    nextButton.removeAttribute('disabled');
                    if (!hasFollowingFieldset()) {
                        confirmButton.removeAttribute('disabled');
                    }
                }
            }
        });

        inputGroups.forEach(group => {
            group.addEventListener('change', (ev) => {
                if (isAnswered(group)) {
                    if (isCategoryAnswered(inputGroups)) {
                        nextButton.removeAttribute('disabled');
                        if (!hasFollowingFieldset()) {
                            confirmButton.removeAttribute('disabled');
                        }
                    }
                }
            });
        });
        setProgressStatus();
    }

    function showModal() {
        confirmModal.classList.remove('hidden');
    }

    function hideModal() {
        confirmModal.classList.add('hidden');
    }

    initValidation();

    nextButton.addEventListener('click', ev => {
        ev.preventDefault();
        if (!ev.target.hasAttribute('disabled')) {
            showNextFieldset();
            initValidation();
        }
    });

    prevButton.addEventListener('click', ev => {
        ev.preventDefault();
        if (!ev.target.hasAttribute('disabled')) {
            showPrevFieldset();
            initValidation();
        }
    });

    confirmButton.addEventListener('click', (ev) => {
        ev.preventDefault();
        showModal();
    });

    cancelButton.addEventListener('click', (ev) => {
        ev.preventDefault();
        hideModal();
    })

    submitButton.addEventListener('click', (ev) => {
        ev.preventDefault();
        fieldsets.forEach(fieldset => {
            const inputs = fieldset.querySelectorAll('input:checked');
            const fieldsetId = fieldset.getAttribute('id');
            const questionsAmount = inputs.length;
            let entry = {};
            let data = {};

            data.totalScore = 0;
            data.mean = 0;
            entry[fieldsetId] = {};

            inputs.forEach(input => {
                data[input.name] = {
                    'question': input.parentElement.parentElement.querySelector('h3').innerText.replace(/(?:\r\n|\r|\n)/g, '').replace(/ +(?= )/g, ''),
                    'answer': input.parentElement.querySelector('span').innerText.replace(/(?:\r\n|\r|\n)/g, '').replace(/ +(?= )/g, ''),
                    'score': input.value,
                }
                data.totalScore += Number(input.value);
            });
            data.mean = data.totalScore / questionsAmount;
            entry[fieldsetId] = data;
            result.push(entry);

        });

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token
            },
            method: 'post',
            credentials: "same-origin",
            body: JSON.stringify(result)
        })
            // .then(res => res.json())
            .then((data) => {
                window.location.reload();
                // window.location.href = redirect;
            })
            .catch(function (error) {
                console.log(error);
            });
    });
}
