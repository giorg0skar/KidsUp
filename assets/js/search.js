/*Function get_selected_value() takes as a parameter the list
* of radio buttons of some filter and returns an array with
* the index and value of the selected filter.
* In case no list item in this filter is selected the function
* returns -1 as index and null as value.
*/
function get_selected_value(elem){
    var res = new Object();
    res.index = -1;
    res.value = null;
    for (var i = 0, length = elem.length; i < length; i++)
        if (elem[i].checked){
            res.index = i;
            res.value = elem[i].value;
            return res;
        }    
    return res;        
}

/*Function submit_form() does the following:
* - gets the search phrase, area phrase and selected filters from the DOM
* - stores selected filters in cookies (specifically the index of selected radio button for each filter)
* - creates a form with all the parameters needed for the ES search query
* - submits the form
* This function is used as click event listener on each filter and 
* on search button.
*/
function submit_form(page = 1){
    var search = document.getElementsByName("search");
    search = search[0].value;
    var area = document.getElementsByName("area");
    area = area[0].value;
    var age = document.getElementsByName("age_radio");
    var distance = document.getElementsByName("distance_radio");
    var act_kind = document.getElementsByName("act_kind_radio");
    var interval = document.getElementsByName("interval_radio");

    var selected_age = get_selected_value(age);
    var selected_distance = get_selected_value(distance);
    var selected_act_kind = get_selected_value(act_kind);
    var selected_interval = get_selected_value(interval);

    document.cookie = "age="+selected_age.index;
    document.cookie = "distance="+selected_distance.index;
    document.cookie = "act_kind="+selected_act_kind.index;
    document.cookie = "interval="+selected_interval.index;

    var form = document.createElement("form");
    var element1 = document.createElement("input"); 
    var element2 = document.createElement("input");  
    var element3 = document.createElement("input");  
    var element4 = document.createElement("input");  
    var element5 = document.createElement("input");
    var element6 = document.createElement("input");
    var element7 = document.createElement("input");
    
    form.method = "POST";
    form.action = "search_activities.php";   

    element1.value=search;
    element1.name="search";
    element2.value=area;
    element2.name="area";
    element3.value=selected_age.value;
    element3.name="age";
    element4.value=selected_distance.value;
    element4.name="distance";
    element5.value=selected_act_kind.value;
    element5.name="act_kind";
    element6.value=selected_interval.value;
    element6.name="interval";
    element7.value=page;
    element7.name="page";

    form.appendChild(element1);  
    form.appendChild(element2);  
    form.appendChild(element3);  
    form.appendChild(element4);  
    form.appendChild(element5);  
    form.appendChild(element6);  
    form.appendChild(element7); 

    document.body.appendChild(form);

    form.submit();
}

/*Function getCookie() takes as a parameter a key
* and returns the value for this key if it is 
* stored in a cookie. In opposite case it returns -1.*/
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                    c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
            }
    }
    return -1;
}

/*Function initiate_filters() reads selected filter indices
* from the cookies and inserts one cancel-filter button inside 
* div element with id=curr_filters for each selected filter.
* This function is used as load event listener on body element.*/
function initiate_filters(){
    var prev_age = getCookie('age');
    var prev_distance = getCookie('distance');
    var prev_act_kind = getCookie('act_kind');
    var prev_interval = getCookie('interval');

    //console.log(prev_age);
    //console.log(prev_distance);
    //console.log(prev_act_kind);
    //console.log(prev_interval);

    var x_icon = "<i class=\"indicator fa fa-times\" aria-hidden=\"true\"></i>";
    var style = "margin-right: .5rem; margin-bottom: .5rem";
    if(prev_age != -1){
            var elem = document.getElementsByName('age_radio')[prev_age];
            //console.log(elem.value);
            elem.checked = true;
            var button = document.createElement('button');
            button.innerHTML = 'Ηλικία'+ elem.nextSibling.nodeValue + " " + x_icon;
            button.setAttribute("nodeType", "button");
            button.setAttribute("id", "selected_age");
            button.setAttribute("class", "btn btn-sm btn-light");
            button.setAttribute("style", style);
            button.setAttribute("onclick", "remove_filter(this.id)");
            document.getElementById('curr_filters').appendChild(button);
    }    
    if(prev_distance != -1){
            var elem = document.getElementsByName('distance_radio')[prev_distance];
            //console.log(elem.value);
            elem.checked = true;
            var button = document.createElement('button');
            button.setAttribute("nodeType", "button");
            button.setAttribute("id", "selected_distance");
            button.setAttribute("class", "btn btn-sm btn-light");
            button.setAttribute("style", style);
            button.setAttribute("onclick", "remove_filter(this.id)");
            button.innerHTML = 'Απόσταση'+ elem.nextSibling.nodeValue + " " + x_icon;
            document.getElementById('curr_filters').appendChild(button);
    }
    if(prev_act_kind != -1){
            var elem = document.getElementsByName('act_kind_radio')[prev_act_kind];
            //console.log(elem.value);
            elem.checked = true;
            var button = document.createElement('button');
            button.setAttribute("id", "selected_act_kind");
            button.setAttribute("nodeType", "button");
            button.setAttribute("class", "btn btn-sm btn-light");
            button.setAttribute("style", style);
            button.setAttribute("onclick", "remove_filter(this.id)");
            button.innerHTML = elem.nextSibling.nodeValue + " " + x_icon;
            document.getElementById('curr_filters').appendChild(button);
    }		
    if(prev_interval != -1){
            var elem = document.getElementsByName('interval_radio')[prev_interval];
            //console.log(elem.value);
            elem.checked = true;
            var button = document.createElement('button');
            button.setAttribute("nodeType", "button");
            button.setAttribute("id", "selected_interval");
            button.setAttribute("class", "btn btn-sm btn-light");
            button.setAttribute("style", style);
            button.setAttribute("onclick", "remove_filter(this.id)");
            button.innerHTML = 'Διάστημα'+ elem.nextSibling.nodeValue + " " + x_icon;
            document.getElementById('curr_filters').appendChild(button);
    }		
}

/*Function remove_filter() takes as a parameter a filter name
* and does the following:
* - read selected filter indices from cookies
* - unckeck the radio button that corresponds to the filter name
*   that was given as input parameter (the selected filter value
    is defined from the associated cookie)
* - call submit_form() to perform a new search
* This function is used as click event listener on cancel-filter
* buttons.
*/
function remove_filter(filter_id){
    var prev_age = getCookie('age');
    var prev_distance = getCookie('distance');
    var prev_act_kind = getCookie('act_kind');
    var prev_interval = getCookie('interval');
    
    if(filter_id == "selected_age"){
            document.getElementsByName('age_radio')[prev_age].checked = false;
    }else if(filter_id == "selected_distance"){
            document.getElementsByName('distance_radio')[prev_distance].checked = false;
    }else if(filter_id == "selected_act_kind"){
            document.getElementsByName('act_kind_radio')[prev_act_kind].checked = false;
    }else if(filter_id == "selected_interval"){
            document.getElementsByName('interval_radio')[prev_interval].checked = false;
    }
    
    submit_form();
}    