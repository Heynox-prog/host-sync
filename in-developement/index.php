<main>
    <div class="annonce-container">
        <div class="title">
            <h1 class="main-title">
                En développement <span id="dots"></span>
            </h1>
        </div>
        <div class="content">
            <p>
                La page à laquelle vous essayez d'accéder est actuellement en cours de développement. Nous travaillons dur pour vous offrir une expérience optimale. Merci de votre patience et de votre compréhension.
            </p>
        </div>
    </div>
</main>

<script>
    let dots = document.getElementById("dots");
    let dotCount = 0;

    setInterval(() => {
        dotCount = (dotCount + 1) % 4;
        dots.textContent = '.'.repeat(dotCount);
    }, 500);
</script>