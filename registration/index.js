// import Model from './model.js';
// import View from './view.js';
//
// document.addEventListener('DOMContentLoaded', () => {
    const title = document.getElementById('title');
    const description = document.getElementById('description');
    const table = document.getElementById('table');
    const amount = document.getElementById('amount');
    const owner = document.getElementById('owner');
    // const alert = document.getElementById('alert');
    const btn = document.getElementById('add');
    let id = 1;

    function removeTodo(id){
        document.getElementById(id).remove();
    }

    function addTodo() {
        if(title.value === '' || description.value === '' || amount.amount === ''){
        //     alert.classList.remove('d-none');
        //     alert.innerText = 'Tiltelelelel';
            return;
        }

        // alert.classList.add('d-none');
        const row = table.insertRow();
        row.setAttribute('id', id++);
        row.innerHTML = `
            <td>${title.value}</td>
            <td>${description.value}</td>
            <td>${amount.value}</td>
            <td>${owner.value}</td>
            <td class="text-center">
                <input type="checkbox">
            </td>
            <td class="text-right">
                <button class = "btn btn-primary mb-1">
                    <i class="fa fa-pencil"></i>
                </button>
            </td>
        `;

        const removeBtn = document.createElement('Button');
        removeBtn.classList.add('btn', 'btn-danger', 'mb-1', 'ml-1');
        removeBtn.innerHTML = '<img src="trash.svg" alt=""> ';
        removeBtn.onclick = function (e) {
            removeTodo(row.getAttribute('id'));
        }
        row.children[5].appendChild(removeBtn);
    }
    btn.onclick = addTodo;

        // alert.classList.add('d-none')



//   const model = new Model();
//   const view = new View();
//   model.setView(view);
//   view.setModel(model);
//
//   view.render();
// });
