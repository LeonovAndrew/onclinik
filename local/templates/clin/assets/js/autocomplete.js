function autocomplete(input, data, callback) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    let currentFocus;
    /*execute a function when someone writes in the text field:*/
    $(input).on('input', function(e) {
        let itemsWrap, item, i, val = this.value, strPos;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        itemsWrap = document.createElement("DIV");
        itemsWrap.setAttribute("id", this.id + "autocomplete-list");
        itemsWrap.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(itemsWrap);
        /*for each item in the array...*/
        for (i = 0; i < data.length; i++) {
            if (data[i] != null) {
                /*check if the item starts with the same letters as the text field value:*/
                strPos = data[i].toUpperCase().indexOf(val.toUpperCase());
                if (strPos >= 0) {
                    /*create a DIV element for each matching element:*/
                    item = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    item.innerHTML = data[i].substr(0, strPos);
                    item.innerHTML += "<strong>" + data[i].substr(strPos, val.length) + "</strong>";
                    item.innerHTML += data[i].substr(strPos + val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    item.innerHTML += "<input type='hidden' value='" + data[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    item.addEventListener("click", function(e) {
                        e.preventDefault();
                        /*insert the value for the autocomplete text field:*/
                        input.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                        callback();
                    });
                    itemsWrap.appendChild(item);
                }
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    $(input).on('keydown', function(e) {
        let acItems = $('#' + this.id + 'autocomplete-list').find('div');

        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(acItems);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(acItems);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1 && acItems[0]) {
                /*and simulate a click on the "active" item:*/
                acItems[currentFocus].click();
            }
        }
    });
    function addActive(item) {
        /*a function to classify an item as "active":*/
        if (!item) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(item);
        if (currentFocus >= item.length) {
            currentFocus = 0;
        }
        if (currentFocus < 0) {
            currentFocus = (item.length - 1);
        }
        /*add class "autocomplete-active":*/
        item[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(item) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (let i = 0; i < item.length; i++) {
            item[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(element) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        let acItems = $(".autocomplete-items");
        for (let i = 0; i < acItems.length; i++) {
            if (element != acItems[i] && element != input) {
                acItems[i].parentNode.removeChild(acItems[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    $(document).on('click', function (e) {
        closeAllLists(e.target);
    });
}
