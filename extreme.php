<?php
// Inclusion du header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les extrêmes des JO</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/js/flag-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/css/main.css" rel="stylesheet">


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        h2 {
            font-family: 'Georgia', 'Times New Roman', serif; /* Nouvelle police */
            font-size: 2.5rem; /* Augmenté pour un meilleur impact */
            text-align: center;
            color: #1e4356;
            font-weight: bold; /* Gras */
            margin-bottom: 20px;
        }
        h2 i {
            color: #ffc107;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        th, td {
            padding: 15px;
            text-align: center;
            font-size: 1rem;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        td {
            border: 1px solid #ddd;
        }
        .gold { background-color: #ffd700; color: #000; }
        .silver { background-color: #c0c0c0; color: #000; }
        .bronze { background-color: #cd7f32; color: #fff; }
        .country-flag {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .flag-icon {
            width: 25px;
            height: 15px;
        }
    </style>
</head>

<body>
<main class="container mt-5">
    <h2 class="text-center">
        Les Extrêmes de JO 
    </h2>
</main>
    
    <script>
        // Charger le fichier CSV
        d3.csv("archive/athletes.csv").then(data => {
            data.forEach(d => {
                d.height = +d.height;
                d.weight = +d.weight;
                d.birth_date = new Date(d.birth_date);
            });

            const plusGrand = d3.max(data, d => d.height);
            const plusPetit = d3.min(data.filter(d => d.height > 0), d => d.height);
            const plusLourd = d3.max(data, d => d.weight);
            const plusLeger = d3.min(data.filter(d => d.weight > 0), d => d.weight);
            const plusAge = d3.min(data, d => d.birth_date);
            const plusJeune = d3.max(data, d => d.birth_date);

            const athPlusGrand = data.find(d => d.height === plusGrand);
            const athPlusPetit = data.find(d => d.height === plusPetit);
            const athPlusLourd = data.find(d => d.weight === plusLourd);
            const athPlusLeger = data.find(d => d.weight === plusLeger);
            const athPlusAge = data.find(d => d.birth_date.getTime() === plusAge.getTime());
            const athPlusJeune = data.find(d => d.birth_date.getTime() === plusJeune.getTime());

            const extrêmes = [
                { titre: "Le plus grand", athlète: athPlusGrand, image: "https://th.bing.com/th/id/OIF.VwWwYlqkK0tw8gFv2vP4nQ?w=267&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7", texte: "Victor Wembanyama est un joueur de basket-ball français, connu pour son exceptionnelle taille et ses performances impressionnantes dans les compétitions internationales." },
                { titre: "La plus petite", athlète: athPlusPetit, image: "https://th.bing.com/th/id/OIP.dJxdU8ymzvHF_uvj6GTBrwHaHa?rs=1&pid=ImgDetMain", texte: "Avell Chitundu est une joueuse de football zambienne, admirée pour sa vitesse et son habileté malgré sa petite taille." },
                { titre: "Le plus lourd", athlète: athPlusLourd, image: "https://img.lamontagne.fr/oKbU8XuN9wp6Yc6fgg6GWHGKPMvloJOQ47nURLHOkl0/fit/657/438/sm/0/bG9jYWw6Ly8vMDAvMDAvMDQvNTMvNzUvMjAwMDAwNDUzNzU3Mg.jpg", texte: "Josaia Raisuqe est un joueur de rugby sevens de Fidji, connu pour sa puissance physique impressionnante." },
                { titre: "La plus légere", athlète: athPlusLeger, image: "https://www.lessportives.fr/wp-content/uploads/2019/05/JASON-IAN-1-600x600.jpg", texte: "Ian Jason est une joueuse de rugby sevens française, rapide et agile, malgré son poids léger." },
                { titre: "La plus âgée", athlète: athPlusAge, image: "https://imgk.timesnownews.com/story/marry-hana-AP.jpg?tr=w-1200,h-900", texte: "Mary Hanna est une cavalière australienne de dressage, ayant participé à plusieurs Olympiades au fil des décennies." },
                { titre: "Le plus jeune", athlète: athPlusJeune, image: "https://cdn.i-scmp.com/sites/default/files/styles/768x768/public/d8/images/canvas/2024/07/01/3086057d-4039-4d7a-b936-2cd798b2f44b_075afc0d.jpg?itok=EyFwGI1n&v=1719806879", texte: "Zheng Haohao est une skieuse chinoise, la plus jeune à participer aux Jeux Olympiques dans sa discipline." }
            ];

            const container = d3.select(".container");

            extrêmes.forEach((ext, index) => {
                const featureItem = container.append("div")
                    .attr("class", `row gy-4 align-items-center features-item ${(index % 2 === 0) ? '' : 'flex-row-reverse'}`)
                    .attr("data-aos", "fade-up");

                // Image
                featureItem.append("div")
                    .attr("class", "col-md-5 d-flex align-items-center")
                    .append("img")
                    .attr("src", ext.image)
                    .attr("alt", `Image de ${ext.athlète.name}`)
                    .attr("class", "img-fluid");

                // Content
                const content = featureItem.append("div")
                    .attr("class", "col-md-7");

                content.append("h3").text(ext.titre);
                let details = `Nom: ${ext.athlète.name}`;
                if (ext.athlète.height > 0) details += `\nTaille: ${ext.athlète.height} cm`;
                if (ext.athlète.weight > 0) details += `\nPoids: ${ext.athlète.weight} kg`;
                if (ext.athlète.birth_date) details += `\nDate de naissance: ${ext.athlète.birth_date.toISOString().split('T')[0]}`;
                if (ext.athlète.country) details += `\nPays: ${ext.athlète.country}`;
                if (ext.athlète.gender) details += `\nSexe: ${ext.athlète.gender}`;
                if (ext.athlète.disciplines) details += `\nDiscipline: ${ext.athlète.disciplines}`;

                content.append("p").attr("class", "fst-italic").html(details);
                content.append("p").text(ext.texte);
            });
        }).catch(error => {
            console.error("Erreur lors du chargement des données :", error);
        });
    </script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

<?php
// Inclusion du footer
include 'footer.php';
?>
</body>

</html>
