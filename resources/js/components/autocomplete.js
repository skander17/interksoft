import autoComplete from "@tarekraafat/autocomplete.js/src/models/autoComplete";
export default {
    typeahead: (config) => {
        return new autoComplete({
            data: {                              // Data src [Array, Function, Async] | (REQUIRED)
                src: async () => {
                    // API key token
                    // User search query
                    // Fetch External Data Source

                    for (const paramsKey in config.params) {
                        console.log(paramsKey)
                        if (config.params[paramsKey] instanceof HTMLElement){
                            console.log(document.getElementById(config.params[paramsKey].id).value)
                            config.params[paramsKey] = document.getElementById(config.params[paramsKey].id).value
                        }
                    }
                    const source = await window.axios.get(config.uri,{
                        params: config.params
                    });
                    // Format data into JSON
                    // Return Fetched data
                    return await source.data;
                },
                key: ["name","full_name","ful_name"],
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
            debounce: 200,                       // Post duration for engine to start | (Optional)
            //searchEngine: "strict",              // Search Engine type/mode           | (Optional)
            resultsList: {                       // Rendered results list object      | (Optional)
                render: true,
                /* if set to false, add an eventListener to the selector for event type
                   "autoComplete" to handle the result */
                container: source => {
                    source.setAttribute("id", Math.random().toString(36).substring(7));
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
                result.innerHTML = "No Results";
                document.querySelector("#autoComplete_list").appendChild(result);
            },
            onSelection: feedback => {             // Action script onSelection event | (Optional)
                config.destination.value = feedback.selection.value[config.select_id || 'id']
                document.querySelector(config.element).value = feedback.selection.value.name || feedback.selection.value.full_name || feedback.selection.value.ful_name
            }
        })
    }};
