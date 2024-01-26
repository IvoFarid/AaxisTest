import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  addAnotherProductIndex()
  {
    let div = document.querySelector('#inputdivs');
    let lastDiv = div.lastElementChild;
    // i select my inputDivs, and then select the last child.
    let lastDivId = lastDiv.getAttribute('id');
    let lastId = lastDivId.substr(-1);
    // then, i can make a substring function that will return me the exact id i need to paste another div of inputs.
    lastId++;
    let html = `<div id='inputdiv-${lastId}' class="d-flex gap-2"><div class="d-flex flex-column"><label for='sku' class="text-white">SKU</label> <input type='text' placeholder='sku' data-productsForm-target='sku' name='products[product-${lastId}][]' required></div><div class="d-flex flex-column"><label for='name' class="text-white">Name</label><input type='text' placeholder='name' data-productsForm-target='name' name='products[product-${lastId}][]' required></div><div class="d-flex flex-column"><label for='description' class="text-white">Description</label><input type='text' placeholder='description' data-productsForm-target='description' name='products[product-${lastId}][]' required></div></div>`
    div.insertAdjacentHTML('beforeend', html)
  }
}
