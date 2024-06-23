jQuery(document).ready(function($) {
    // if (window.location.pathname === '/services') {
        // Populate the sidebar with initial links
    $('#org-chart-sidebar').html(`
        <ul>
            <li><a href="#" class="active">All Lifecycle Services</a></li>
            <li><a href="#">Advisory</a></li>
            <li><a href="#">Design</a></li>
            <li><a href="#">Implementation</a></li>
            <li><a href="#">Support</a></li>
            <li><a href="#">Assessments</a></li>
            <li><a href="#">Trainings</a></li>
        </ul>
        <div id="select-container">
            <select id="technology">
                <option value="">Select Technology</option>
            </select>
            <select id="subtechnology">
                <option value="">Select Subtechnology</option>
            </select>
            <select id="vendor">
                <option value="">Select Vendor</option>
            </select>
            <select id="product">
                <option value="">Select Product</option>
            </select>
        </div>
        <div id="card-container"></div>
    `);

    // Fetch data from the internal API
    $.ajax({
        url: '/lifecycle-services/wp-content/plugins/lifecycle-services/data.json',
        method: 'GET',
        success: function(response) {
            populateSelectOptions(response);
            
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });

    function populateSelectOptions(data) {
        let technologyOptions = '';
        let subtechnologyOptions = '';
        let vendorOptions = '';
        let productOptions = '';

        technologyOptions += `<option value="Technology">Technology</option>`;
        technologyOptions += `<option value="tech2">Tech2</option>`;

        subtechnologyOptions += `<option value="subtech1">Subtech1</option>`;
        subtechnologyOptions += `<option value="subtech2">Subtech2</option>`;

        vendorOptions += `<option value="vendor1">Vendor1</option>`;
        vendorOptions += `<option value="vendor2">Vendor2</option>`;

        productOptions += `<option value="product1">Product1</option>`;
        productOptions += `<option value="product2">Product2</option>`;

        $('#technology').append(technologyOptions);
        $('#subtechnology').append(subtechnologyOptions);
        $('#vendor').append(vendorOptions);
        $('#product').append(productOptions);

        const selectedItems = {
            technology: $('#technology').val(),
            subtechnology: $('#subtechnology').val(),
            vendor: $('#vendor').val(),
            product: $('#product').val()
        };
        const filteredData = filterData(data, selectedItems);
        displayCards(filteredData);
    }

    // Event listener for select options
    $('.filter-options').on('change', function() {
        $('#card-container').html()
        const selectedItems = {
            technology: $('#technology').val(),
            subtechnology: $('#subtechnology').val(),
            vendor: $('#vendor').val(),
            product: $('#product').val()
        };

        // Fetch data based on selected items
        $.ajax({
            url: '/lifecycle-services/wp-content/plugins/lifecycle-services/data.json',
            method: 'GET',
            success: function(response) {
                const filteredData = filterData(response, selectedItems);
                console.log(filteredData)
                displayCards(filteredData);
            },
            error: function(error) {
                console.error('Error fetching filtered data:', error);
            }
        });
    });

    function filterData(data, selectedItems) {
        return data.filter(item => {
            console.log(`Selected Item: ${item.category}`)
            console.log(`Selected Category: ${selectedItems.technology}`)
            return (selectedItems.technology === '' || item.category === selectedItems.technology) ||
            (selectedItems.subtechnology === '' || item.category === selectedItems.subtechnology) ||
            (selectedItems.vendor === '' || item.category === selectedItems.vendor) ||
            (selectedItems.product === '' || item.category === selectedItems.product);
        });
    }

    function displayCards(items) {
        let cardContainer = $('#card-container');
        cardContainer.empty();
        items.forEach(item => {
            cardContainer.append(`
            <div class="border border-[#ddd] p-3 rounded-md my-2 bg-white">
                <span class="font-bold text-lg">${item.category}</span>
                <hr>
                <h2>${item.title}</h2>
                <p>${item.description}</p>
            </div>
            `);
        });
    }
    // }


    $('.nav-options').on('click', function () {
        $('.nav-options').removeClass('active')
        $(this).toggleClass('active')
    })

    jQuery(document).ready(function($) {
        if (window.location.pathname === '/services') {
            $('#org-chart-sidebar').html(`
                <ul>
                    <li><a href="#" class="active">All Lifecycle Services</a></li>
                    <li><a href="#">Advisory</a></li>
                    <li><a href="#">Design</a></li>
                    <li><a href="#">Implementation</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Assessments</a></li>
                    <li><a href="#">Trainings</a></li>
                </ul>
            `);
        }
    });
    
});
