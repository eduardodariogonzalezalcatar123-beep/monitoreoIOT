async function cargarSensores() {
    try {
        const res = await fetch("http://localhost:8080/api/sensores");
        const data = await res.json();

        document.querySelectorAll(".value")[0].innerText = data.sensor1 + " °C";
        document.querySelectorAll(".value")[1].innerText = data.sensor2 + " °C";

    } catch (error) {
        console.log("Error cargando sensores", error);
    }
}

cargarSensores();