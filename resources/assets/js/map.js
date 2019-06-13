export function Map() {
    return new Promise(function (resolve, reject) {
        window.init = function () {
            resolve(AMap)
        };
        let script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://webapi.amap.com/maps?v=1.4.14&key=a53a7f7c6ad37688738f2aceb6644274&plugin=AMap.Geocoder&callback=init';
        script.onerror = reject;
        document.head.appendChild(script);
    });
}