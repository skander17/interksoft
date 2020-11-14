import autoComplete from "@tarekraafat/autocomplete.js/src/models/autoComplete";
export default {
    typeahead: (config) => {
        const list_id = Math.random().toString(36).substring(7);
        return new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: async () => {
                    // API key token
                    // User search query
                    // Fetch External Data Source
                    let params = config.params;
                    let new_params = {};
                    for (const paramsKey in params) {
                        if (params[paramsKey] instanceof HTMLElement){
                            new_params[paramsKey] = document.getElementById(params[paramsKey].id).value
                        }
                    }
                    const source = await window.axios.get(config.uri,{
                        params: new_params
                    });
                    // Format data into JSON
                    // Return Fetched data
                    return await source.data;
                },
                key: config.keys,
                cache: false
            },
            /*query: {                               // Query Interceptor               | (Optional)
                manipulate: (query) => {
                    return query.replace("pizza", "burger");
                }
            },*/
            sort: (a, b) => {                    // Sort rendered results ascendingly | (Optional)
                if (a.match < b.match) return -1;
                if (a.match > b.match) return 1;
                return 0;
            },
            placeHolder: config.placeholder || "",     // Place Holder text                 | (Optional)
            selector: config.element,                   // Input field selector              | (Optional)
            //threshold: 3,                        // Min. Chars length to start Engine | (Optional)
            debounce: 100,                       // Post duration for engine to start | (Optional)
            //searchEngine: "strict",              // Search Engine type/mode           | (Optional)
            resultsList: {                       // Rendered results list object      | (Optional)
                render: true,
                /* if set to false, add an eventListener to the selector for event type
                   "autoComplete" to handle the result */
                container: source => {
                    source.setAttribute("id", list_id);
                    source.classList.add("ul-style");
                },
                destination: config.destination,
                position: "afterend",
                element: "ul"
            },
            //maxResults: 10,                         // Max. number of rendered results | (Optional)
            highlight: true,                       // Highlight matching results      | (Optional)
            resultItem: {                          // Rendered result item            | (Optional)
                content: (data, source) => {
                    source.innerHTML = data.match;
                },
                element: "li"
            },
            noResults: () => {                     // Action script on noResults      | (Optional)
                const result = document.createElement("li");
                result.setAttribute("class", "no_result");
                result.setAttribute("tabindex", "1");
                result.innerHTML = "Sin resultados";
                document.getElementById(list_id).appendChild(result);
            },
            onSelection: feedback => {             // Action script onSelection event | (Optional)
                config.destination.value = feedback.selection.value[config.select_id || 'id']
                document.querySelector(config.element).value = feedback.selection.value.name || feedback.selection.value.full_name || feedback.selection.value.ful_name
            }
        })
    }};
