<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header">Users:</div>
                <div class="card-body">
                    <h5 class="card-title">Total: <?php echo $users_total; ?></h5>
                    <p class="card-text">Active:  <?php echo $users_active; ?></p>
                    <p class="card-text">Disabled:  <?php echo $users_disabled; ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">Surveys:</div>
                <div class="card-body">
                    <h5 class="card-title">Total: <?php echo $surveys_total; ?></h5>
                    <p class="card-text">Public:  <?php echo $surveys_public; ?></p>
                    <p class="card-text">Private:  <?php echo $surveys_private; ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Questions:</div>
                <div class="card-body">
                    <h5 class="card-title">Total: <?php echo $surveys_questions; ?></h5>
                    <p class="card-text">&nbsp;</p>
                    <p class="card-text">&nbsp;</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Answers:</div>
                <div class="card-body">
                    <h5 class="card-title">Total: <?php echo $surveys_answers; ?></h5>
                    <p class="card-text">&nbsp;</p>
                    <p class="card-text">&nbsp;</p>
                </div>
            </div>
        </div>
    </div>
</div>
