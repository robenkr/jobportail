<h4 class="center blue-grey-text"><?php echo ucfirst($title);?></h4>
<div class="row">
    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content black-text">
                <?php echo form_open('update_uemplois','class =""');?>
                    <div class="input-field col s10 offset-s1">
                        <i class="material-icons prefix">attach_file</i>
                        <input id="icon_post" type="text" class="validate">
                        <label for="icon_post">Poste Emplois</label>
                    </div>
                    <div class="input-field col s10 offset-s1">
                        <i class="material-icons prefix">business</i>
                        <input id="icon_entre" type="text" class="validate">
                        <label for="icon_entre">Nom Entreprise</label>
                    </div>
                    <div class="row">
                        <div class="input-field col s5 offset-s1">
                            <i class="material-icons prefix">event</i>
                            <input type="text" class="datepicker" placeholder="Date de la Realisation" id="date_debut">
                            <label for="date_debut">Date de Debut</label>
                        </div>
                        <div class="input-field col s5 offset-s1">
                            <i class="material-icons prefix">event</i>
                            <input type="text" class="datepicker" placeholder="Date de la Realisation" id="date_fin">
                            <label for="date_fin">Date de Fin</label>
                        </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" value="Modifier">Modifier
                        <i class="material-icons right">cached</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>