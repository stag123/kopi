
class Net {

    static ajax (method, url, data, cache, options = {}) {
        const MAX_QUERY_LENGTH = 200;

        let XHRProvider = ("onload" in new XMLHttpRequest()) ? XMLHttpRequest : XDomainRequest,
            xhr = new XHRProvider(),
            request,
            query = "",
            body = JSON.stringify(data);

        if (method === "GET" && body.length < MAX_QUERY_LENGTH) {
            query = "r=" + encodeURIComponent(body);
            body = "{}";
        } else {
            method = "POST";
        }

        let _separator = url.indexOf('?') !== -1 ? '&': '?';

        if (query) {
            url = cache ? url + _separator + query : url + _separator + query + "&_=" + Math.random();
        }

        xhr.open(method, url, true);

        if (!options.fetch) {
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        }
        if (options.contentType) {
            xhr.setRequestHeader('Content-Type', options.contentType);
        } else {
            xhr.setRequestHeader('Content-Type', 'text/plain');
        }

        xhr.withCredentials = options.credentials === false ? false : true;
        xhr.aborting = false;
        xhr.json = options.json === false ? false: true;

        request = new Promise((resolve, reject) => {

            xhr.onreadystatechange = function () {
                if (this.readyState != 4) return;

                let answer;

                try {
                    answer = xhr.json ? JSON.parse(xhr.responseText || "{}"): xhr.responseText;
                }
                catch (e) {
                    answer = [];
                    __DEV__ || console.error("Net: ajax response json parse error");
                }
                finally {
                    if (xhr.status != 200) {
                        reject({
                            statusText: xhr.aborting ? "abort" : xhr.statusText,
                            status: xhr.status,
                            responseJSON: answer
                        });

                        return;
                    }

                    resolve(answer);
                }
            };

        });

        request.abort = function () {
            xhr.aborting = true;
            xhr.abort();
        };

        xhr.send(body);

        return request;
    }
}

export default Net;