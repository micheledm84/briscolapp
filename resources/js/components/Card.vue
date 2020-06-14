<template>
    <div v-if="state === '1'" >
        <div class="jumbotron jumbotron-fluid bg-dark">
            <div class="container">
                <h1 class="text-success text-center display-2 font-weight-bold">BRISCOLAPP</h1>
            </div>
        </div >
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <form class="col-6 col-sm-4 text-center">
                    <h2 class="text-warning display-5 font-italic">Insert your name:</h2>
                    <input v-model.trim="name_user" type="text" class="form-control mt-4" id="pname" name="pname" maxlength="10" style="font-weight: bold;">
                    <input @click="change_state('2')" class="btn btn-warning mt-4 font-weight-bold" type="button" value="Play the game">
                </form>   
            </div>
        </div>
    </div>
    <div v-else-if="state === '2'">
        <app-header :nav_comment="nav_comment" :remaining_cards="remaining_cards"></app-header>
        <div class="row justify-content-center align-items-center mt-2">
            <img src="images/retro.jpg" v-bind:class="{card:true, invisible:pc_left_invisible}" id="pc_left" v-bind:rel="pc_left_rel">
            <img src="images/retro.jpg" v-bind:class="{card:true, invisible:pc_center_invisible}" id="pc_center" v-bind:rel="pc_center_rel">
            <img src="images/retro.jpg" v-bind:class="{card:true, invisible:pc_right_invisible}" id="pc_right" v-bind:rel="pc_right_rel">
        </div>
        <div class="row mt-2">
            <div class="col-3 d-flex justify-content-start pl-5">
                <img src="images/retro.jpg" v-bind:class="{card:true, invisible:pack_cards_invisible}" id="pack_cards" rel="0">
            </div>
            <div class="col-6 d-flex justify-content-center">
                <img v-bind:src="pc_game_src" v-bind:class="{card:true, invisible:pc_game_invisible}" id="pc_game" v-bind:rel="pc_game_rel">
                <img v-bind:src="player_game_src" v-bind:class="{card:true, invisible:player_game_invisible}" id="player_game" v-bind:rel="player_game_rel">
            </div>
            <div class="col-3 d-flex justify-content-end pr-5">
                <img v-bind:src="game_briscola_src"  v-bind:class="{card:true, invisible:game_briscola_invisible}" id="game_briscola" v-bind:rel="game_briscola_rel">
            </div>
        </div>
        <div class="row justify-content-center align-items-center mt-2">
            <img @click="play($event)" v-bind:src="player_left_src" v-bind:class="{card:true, invisible:player_left_invisible}" id="player_left" v-bind:rel="player_left_rel">
            <img @click="play($event)" v-bind:src="player_center_src" v-bind:class="{card:true, invisible:player_center_invisible}" id="player_center" v-bind:rel="player_center_rel">
            <img @click="play($event)" v-bind:src="player_right_src" v-bind:class="{card:true, invisible:player_right_invisible}" id="player_right" v-bind:rel="player_right_rel">

        </div>
        <app-footer :footer_score="footer_score"></app-footer>
    </div>
    <div v-else>
        <div class="container h-100">
            <h1 class="text-warning display-3 font-italic text-center mt-2 font-weight-bold">GAME FINISHED</h1>
            <div class="row h-100 justify-content-center align-items-center">
                
                <div class="col-sm-8 col-sm-offset-2 text-center mt-5 text-warning">
                    
                    <h2 class="display-5 text-primary font-italic  font-weight-bold">FINAL RESULT</h2>
                    <h3 class="display-5 text-primary">{{ final_score }}</h3>
                    <h2 class="display-5 text-danger font-italic  font-weight-bold mt-3">CURRENT SCORE</h2>
                    <h3 class="display-5 text-danger">{{ footer_score }}</h3>
                    <h2 class="display-5 text-info font-italic  font-weight-bold mt-3">YOUR LEVEL</h2>
                    <h3 class="display-5 text-info">{{ level_player }}</h3>
                </div>  
            </div>
            <div class="container h-100">
                <div class="row h-100 justify-content-center align-items-center mt-5 mb-1">
                    <input @click="change_state_restart()" class="btn btn-warning mt-4 font-weight-bold btn-lg" type="button" value="Play again">
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import Header from "./Header.vue"
import Footer from "./Footer.vue"
export default {
    components: {
        'app-header': Header,
        'app-footer': Footer
    },
    data() {
        return {
            level_player: "so-so",
            pc_win: 0,
            player_win: 0,
            remaining_cards: 40,
            //remaining_cards: 6,
            //remaining_cards: 20,
            //remaining_cards_header: 20,
            player_cards: [],
            pc_cards: [],
            player_start: true,
            //player_start: false,
            //match_finished: false,
            //cards: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'],
            //pc_cards_seen: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'],
            pc_cards_seen: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'],
            //cards: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            pc_cards_seen: [ '17', '25', '7'],
            
            cards: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'],
            scartelle: ['1', '2', '3', '4', '5', '11', '12', '13', '14', '15', '21', '22', '23', '24', '25', '31', '32', '33', '34', '35'],
            punti: ['6', '7', '8', '16', '17', '18', '26', '27', '28', '36', '37', '38'],
            carichi: ['9', '10', '19', '20', '29', '30', '39', '40'],
            bastoni: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            spade: ['11', '12', '13', '14', '15', '16', '17', '18', '19', '20'],
            denari: ['21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
            coppe: ['31', '32', '33', '34', '35', '36', '37', '38', '39', '40'],
            tre: ['9', '19', '29', '39'],
            assi: ['10', '20', '30', '40'],
            fanti: ['6', '16', '26', '36'],
            cavalli: ['7', '17', '27', '37'],
            re: ['8', '18', '28', '38'],
            //briscole: [],
            player_points: 0,
            pc_points: 0,
            //turn_points: 0,
            nav_comment: "Have a nice start!",
            pack_cards_invisible: false,
            //pack_cards_invisible: true,
            pc_game_rel: "0",
            pc_game_src: "images/retro.jpg",
            pc_game_invisible: true,
            player_left_invisible: false,
            player_center_invisible: false,
            player_right_invisible: false,
            player_game_rel: "0",
            player_game_src: "images/retro.jpg",
            player_game_invisible: true,
            player_left_src: "images/retro.jpg",
            player_center_src: "images/retro.jpg",
            player_right_src: "images/retro.jpg",
            player_left_rel: "0",
            player_center_rel: "0",
            player_right_rel: "0",
            pc_left_rel: "0",
            pc_center_rel: "0",
            pc_right_rel: "0",
            pc_left_invisible: false,
            pc_center_invisible: false,
            pc_right_invisible: false,
            game_briscola_rel: "0",
            //game_briscola_rel: "25",
            game_briscola_src: "images/retro.jpg",
            game_briscola_invisible: true,
            briscola_sign: 0,
            state: '1',
            //color: 'yellow',
            colorChosen: 'bg_state_1',
            name_user: "",
        }
    },
    mounted: function () {
        var arr_len = 0;
        var i = 1;
        var arr_num = 0;
        var arr_images = [];
        var arr_rels = [];
        while (i <= 7) {
            arr_len = this.cards.length;
            arr_num = Math.floor(Math.random() * arr_len);
            var src_image = this.num_to_src(this.cards[arr_num]);
            arr_rels.push(this.cards[arr_num]);
            arr_images.push(src_image);
            this.cards.splice(arr_num, 1);
            i++;
        }
        /*this.player_left_src = this.num_to_src('25');
        this.player_center_src = this.num_to_src('17');
        this.player_right_src = this.num_to_src('7');
        this.game_briscola_src = this.num_to_src('25');;
        this.game_briscola_rel = '25';
        this.game_briscola_invisible = true;
        this.player_left_rel = '25';
        this.player_center_rel = '17';
        this.player_right_rel = '7';
        this.pc_left_rel = '31';
        this.pc_center_rel = '15';
        this.pc_right_rel = '5';*/
        this.player_left_src = arr_images[0];
        this.player_center_src = arr_images[1];
        this.player_right_src = arr_images[2];
        this.game_briscola_src = arr_images[6];
        this.game_briscola_rel = arr_rels[6];
        this.game_briscola_invisible = false;
        //this.game_briscola_invisible = true;
        this.player_left_rel = arr_rels[0];
        this.player_center_rel = arr_rels[1];
        this.player_right_rel = arr_rels[2];
        this.pc_left_rel = arr_rels[3];
        this.pc_center_rel = arr_rels[4];
        this.pc_right_rel = arr_rels[5];
        //this.remaining_cards = 34;
        //this.remaining_cards = 14;
        //this.remaining_cards = 20;
        this.create_briscole();
        this.remove_pc_by_rel(this.pc_left_rel);
        this.remove_pc_by_rel(this.pc_center_rel); 
        this.remove_pc_by_rel(this.pc_right_rel); 
        this.remove_pc_by_rel(this.game_briscola_rel); 
        /*this.$root.$on('body-background-color', function(color) {
        //handle the background color change here  
        });*/
        //if (this.state == '1') {
        this.colorChosen = 'bg_state_1';
        document.body.className = this.colorChosen;
        //this.pc_start();
        /*} else if (this.state == '2') {
            this.colorChosen = 'bc-header-green';
            document.body.className = this.colorChosen;
        } else {
            this.colorChosen = 'bc-header-yellow';
            document.body.className = this.colorChosen;
        }*/
        //this.colorChosen = 'bc-header-red';
        //this.handleColorChoice();
        //this.$root.$on('body-background-color', function(color) {
            /*this.color = 'bc-header-red';
            document.body.className = this.color;*/
            /*if (this.state == '1') {
                this.color = 'bc-header-red';
                document.body.className = this.color;
            } else if (this.state == '2') {
                this.color = 'bc-header-green';
                document.body.className = this.color;
            } else {
                this.color = 'bc-header-yellow';
                document.body.className = this.color;
            }
        })*/
    }, //var message = "PC " + this.pc_points + " - " + "PLAYER " + this.player_points;
    computed: {
        footer_score: function () {
            var message = "PC " + " - " + this.name_user + " " + this.pc_win + "-" + this.player_win;
            return message;
        },
        final_score: function () {
            var message = "PC " + " - " + this.name_user + " " + this.pc_points + "-" + this.player_points;
            return message;
        }
    },
    methods: {
        remove_pc_by_rel(rel_pc) {
            var i = 0;
            for (i = 0; i < this.pc_cards_seen.length; i++) {
                if(rel_pc == this.pc_cards_seen[i]) {
                    this.pc_cards_seen.splice(i, 1);
                }
            }

        },
        create_briscole() {
            if (this.denari.includes(this.game_briscola_rel)) {
                this.briscole = this.denari;
                this.briscola_sign = 3;
            } else if (this.bastoni.includes(this.game_briscola_rel)) {
                this.briscole = this.bastoni;
                this.briscola_sign = 1;
            } else if (this.spade.includes(this.game_briscola_rel)) {
                this.briscole = this.spade;
                this.briscola_sign = 2;
            } else {
                this.briscole = this.coppe;
                this.briscola_sign = 4;
            }
        },
        change_state(state_number) {
            if (this.name_user != '') {
                if (state_number == '1') {
                    this.state = '1';
                } else if (state_number == '2') {
                    
                    this.state = '2';
                } else {
                    this.state = '3';
                }
            } else {
                this.state = '1';
            }
            
            
            //alert(this.state);
            
        },
        change_state_restart() {
            //vm.$forceUpdate();
            this.player_start = false;
            this.pc_points = 0;
            this.player_points = 0;
            this.remaining_cards = 40;
            //this.match_finished = false;
            this.pc_cards_seen = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'],
            this.cards = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
            '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40'],
            this.pack_cards_invisible = false;
            this.pc_game_rel = "0";
            this.pc_game_src = "images/retro.jpg";
            this.pc_game_invisible = true;
            this.player_left_invisible = false;
            this.player_center_invisible = false;
            this.player_right_invisible = false;
            this.player_game_rel = "0";
            this.player_game_src = "images/retro.jpg";
            this.player_game_invisible = true;
            this.player_left_src = "images/retro.jpg";
            this.player_center_src = "images/retro.jpg";
            this.player_right_src = "images/retro.jpg";
            this.player_left_rel = "0";
            this.player_center_rel = "0";
            this.player_right_rel = "0";
            this.pc_left_rel = "0";
            this.pc_center_rel = "0";
            this.pc_right_rel = "0";
            this.pc_left_invisible = false;
            this.pc_center_invisible = false;
            this.pc_right_invisible = false;
            this.game_briscola_rel = "0";
            this.game_briscola_src = "images/retro.jpg";
            this.game_briscola_invisible = true;
            this.briscola_sign = 0;
            this.state = '2';
            this.mounted_state_2_again();
            
        },
        mounted_state_2_again() {
            var arr_len = 0;
            var i = 1;
            var arr_num = 0;
            var arr_images = [];
            var arr_rels = [];
            while (i <= 7) {
                arr_len = this.cards.length;
                arr_num = Math.floor(Math.random() * arr_len);
                var src_image = this.num_to_src(this.cards[arr_num]);
                arr_rels.push(this.cards[arr_num]);
                arr_images.push(src_image);
                this.cards.splice(arr_num, 1);
                i++;
            }

            this.player_left_src = arr_images[0];
            this.player_center_src = arr_images[1];
            this.player_right_src = arr_images[2];
            this.game_briscola_src = arr_images[6];
            this.game_briscola_rel = arr_rels[6];
            this.game_briscola_invisible = false;
            this.player_left_rel = arr_rels[0];
            this.player_center_rel = arr_rels[1];
            this.player_right_rel = arr_rels[2];
            this.pc_left_rel = arr_rels[3];
            this.pc_center_rel = arr_rels[4];
            this.pc_right_rel = arr_rels[5];
            this.create_briscole();
            this.remove_pc_by_rel(this.pc_left_rel);
            this.remove_pc_by_rel(this.pc_center_rel); 
            this.remove_pc_by_rel(this.pc_right_rel); 
            this.remove_pc_by_rel(this.game_briscola_rel); 
            this.nav_comment = "Have a nice start!";
            var sum_matches = this.player_win + this.pc_win;
            if (sum_matches % 2 === 0) {
                this.player_start = true;
            } else {
                this.pc_start();
            }
            
            //this.colorChosen = 'bg_state_1';
            //document.body.className = this.colorChosen;
        },

        play(event) {
            /*if (this.remaining_cards == '7' || this.remaining_cards == '5' || this.remaining_cards == '6') {
                this.nav_comment = "LAST ROUND";
            } else {
                //alert(this.remaining_cards + ' 1')
                this.nav_comment = "Have you a nice play!";
            }*/
            
            var src_image = this.num_to_src(event.target.getAttribute("rel"));
            if (this.player_game_invisible === true) {
                if(event.target.id === "player_left") {
                    this.player_left_invisible = true;
                } else if (event.target.id === "player_center") {
                    this.player_center_invisible = true;
                } else {
                    this.player_right_invisible = true;
                }
                
                this.player_game_src = src_image;
                this.player_game_rel = event.target.getAttribute("rel");
                this.player_game_invisible = false;
                this.remaining_cards--;
                if (this.player_start) {
                    this.pc_answer();  
                } 
                this.compare_cards();  
            }
            
        },
        pc_answer() {
            this.remaining_cards--;
            var pc_rels = [];
            var pc_rels_core = [];
            if (this.pc_left_invisible !== true) {
                var temp_pc_left = "0_" + this.pc_left_rel;
                pc_rels.push(temp_pc_left);
                pc_rels_core.push(this.pc_left_rel);
            } 
            if (this.pc_center_invisible !== true) {
                var temp_pc_center = "1_" + this.pc_center_rel;
                pc_rels.push(temp_pc_center);
                pc_rels_core.push(this.pc_center_rel);
            } 
            if (this.pc_right_invisible !== true) {
                var temp_pc_right = "2_" + this.pc_right_rel;
                pc_rels.push(temp_pc_right);
                pc_rels_core.push(this.pc_right_rel);
            }
            if(this.remaining_cards == 6) {
                //this.nav_comment = "LAST ROUND";
                if (this.assi.includes(this.game_briscola_rel) || this.tre.includes(this.game_briscola_rel) || this.highest_by_sign(this.game_briscola_rel)) {
                    //alert("last round not win good briscola 1");
                    
                    if (this.move_not_win_last_round(pc_rels_core, pc_rels)) {
                        //alert("last round not win good briscola 2");
                        return;
                    }
                } else {
                    if (!this.assi.includes(this.player_game_rel) && !this.tre.includes(this.player_game_rel)) {
                        if (this.move_not_win_last_round(pc_rels_core, pc_rels)) {
                            //alert("last round not win not good player game");
                            return;
                        }
                    }
                }
                //alert("last round pc answer");

            }
            if(this.remaining_cards == 4) {
                //alert("first last round pc answer");
                /*if (this.move_scartella_different(pc_rels)) {
                    alert("move_scartella_different");
                    return;
                } else if(this.move_fante_different(pc_rels)) {
                    alert("move_fante_different");
                    return;
                } else if(this.move_cavallo_different(pc_rels)) {
                    alert("move_cavallo_different");
                    return;
                } else if(this.move_re_different(pc_rels)) {
                    alert("move_re_different");
                    return;
                } else if(this.move_same_sign_lower_answer(pc_rels_core, pc_rels)) {
                    alert("move_same_sign_lower_answer");
                    return;
                } else */
                if(this.choose_first_final_round_answer(pc_rels_core, pc_rels)) {
                    //alert("first choice pc answer done");
                    return;
                }
                //alert(pc_rels);
                //alert(pc_rels_core);
                //this.choose_card_last_round_answer(pc_rels_core, pc_rels);
                
            }
            if(this.remaining_cards == 2) {
                //alert(pc_rels);
                //alert(pc_rels_core);
                this.choose_card_last_round_answer(pc_rels_core, pc_rels);
                //alert("last choice pc answer");
                return;
            }
            if (this.move_against_briscola_tre(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_briscola_asso(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_briscola_little(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_tre(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_asso(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_punti(pc_rels_core, pc_rels)) {
                return;
            } else if (this.move_against_scartella(pc_rels_core, pc_rels)) {
                return;
            } else {
                this.random_answer_pc(pc_rels);
                return;
            }
        },
        choose_first_final_round_answer(pc_rels_core, pc_rels) {
            var i = 0;
            var player_asso_briscola = false;
            for (i = 0; i < this.pc_cards_seen.length; i++) {
                if (this.briscole.includes(this.pc_cards_seen[i]) && this.assi.includes(this.pc_cards_seen[i])) {
                    player_asso_briscola = true;
                }
            }
            var i = 0;
            var pc_tre_briscola = false;
            var pc_tre_rel = "100";
            for (i = 0; i < pc_rels_core.length; i++) {
                if (this.briscole.includes(pc_rels_core[i]) && this.tre.includes(pc_rels_core[i])) {
                    pc_tre_briscola = true;
                    pc_tre_rel = pc_rels_core[i];
                }
            }
            if(!this.briscole.includes(this.player_game_rel)) {
                if(!this.have_carichi_above(pc_rels_core, this.player_game_rel) && player_asso_briscola && pc_tre_briscola && !this.tre.includes(this.player_game_rel) && !this.assi.includes(this.player_game_rel)) {
                    if (this.move_scartella_different(pc_rels)) {
                        //alert("move_scartella_different");
                        return true;
                    } else if(this.move_fante_different(pc_rels)) {
                        //alert("move_fante_different");
                        return true;
                    } else if(this.move_cavallo_different(pc_rels)) {
                        //alert("move_cavallo_different");
                        return true;
                    } else if(this.move_re_different(pc_rels)) {
                        //alert("move_re_different");
                        return true;
                    } else if(this.move_same_sign_lower_answer(pc_rels_core, pc_rels)) {
                        //alert("move_same_sign_lower_answer");
                        return true;
                    } else {
                        //alert(pc_tre_rel);
                        //alert(pc_rels_core);
                        //alert(this.pc_cards_seen);
                        this.pc_position_invisible_true(pc_rels, String(pc_tre_rel));
                        this.pc_game_invisible_false(String(pc_tre_rel));
                        //alert("tre against asso briscola");
                        return true;
                    }
                        /*alert(pc_tre_rel);
                        alert(pc_rels_core);
                        alert(this.pc_cards_seen);
                        this.pc_position_invisible_true(pc_rels, String(pc_tre_rel));
                        this.pc_game_invisible_false(String(pc_tre_rel));
                        alert("tre against asso briscola");
                        return true;*/
                }
            }
        },
        move_same_sign_lower_answer(pc_rels_core, pc_rels) {
            var arr_lower = [];
            var sign_card = this.find_sign(this.player_game_rel);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if ((this.find_sign(pc_rels_core[i]) == sign_card) && (parseInt(pc_rels_core[i]) < parseInt(this.player_game_rel)) && !this.tre.includes(pc_rels_core[i])) {
                    //player_asso_briscola = true;
                    arr_lower.push(pc_rels_core[i]);
                    arr_lower.sort();
                }
            }
            if(arr_lower.length > 0) {
                this.pc_position_invisible_true(pc_rels, String(arr_lower[0]));
                this.pc_game_invisible_false(String(arr_lower[0]));
                //alert("lower same sign to loose");
                return true;
            }
        },
        have_carichi_above(pc_rels_core, card_to_check) {
            var sign_card = this.find_sign(card_to_check);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if ((this.find_sign(pc_rels_core[i]) == sign_card) && (this.assi.includes(pc_rels_core[i]) || this.tre.includes(pc_rels_core[i])) && (parseInt(pc_rels_core[i]) > parseInt(card_to_check))) {
                    //player_asso_briscola = true;
                    return true;
                }
            }
        },
        choose_card_last_round_answer(pc_rels_core, pc_rels) {
            var scenario_one = this.total_points_win(pc_rels_core[0], pc_rels_core[1]);
            var scenario_two = this.total_points_win(pc_rels_core[1], pc_rels_core[0]);
            //alert (scenario_one);
            //alert (scenario_two);
            if (scenario_one > scenario_two) {
                this.pc_position_invisible_true(pc_rels, String(pc_rels_core[0]));
                this.pc_game_invisible_false(String(pc_rels_core[0]));
                //alert(scenario_one);
            } else {
                this.pc_position_invisible_true(pc_rels, String(pc_rels_core[1]));
                this.pc_game_invisible_false(String(pc_rels_core[1]));
                //alert(scenario_two);
            }
        },
        total_points_win(card_pc_first, card_pc_second) {
            var i = 0;
            for (i = 0; i < this.pc_cards_seen.length; i++) {
                if (this.pc_cards_seen[i] != this.player_game_rel) {
                    var last_card_player = this.pc_cards_seen[i];
                }
            }
            //var last_card_player = this.pc_cards_seen[0];
            var points_first_round = this.who_win_last_round(card_pc_first, this.player_game_rel, 2);
            if (points_first_round != "-1") {
                var points_second_round = this.who_win_last_round(card_pc_second, last_card_player, 1)
            } else {
                var points_second_round = this.who_win_last_round(card_pc_second, last_card_player, 2)
            }
            if (points_first_round === "-1") {
                points_first_round = 0;
            }
            if (points_second_round === "-1") {
                points_second_round = 0;
            }
            return points_first_round + points_second_round;
        },
        who_win_last_round(card_pc, card_player, who_start) {
            //var return_arr_points = [];
            var sign_pc = this.find_sign(card_pc);
            var sign_player = this.find_sign(card_player);
            if (sign_pc === sign_player) {
                if (parseInt(card_pc) > parseInt(card_player)) {
                    return this.add_points(card_pc) + this.add_points(card_player);
                } else {
                    return "-1";
                } 
            } else if (sign_pc == this.briscola_sign) {
                return this.add_points(card_pc) + this.add_points(card_player);
            } else if (sign_player == this.briscola_sign) {
                return "-1";
            } else {
                if (who_start == 1) {
                    return this.add_points(card_pc) + this.add_points(card_player);
                } else {
                    return "-1";
                }
            }

        },
        move_not_win_last_round(pc_rels_core, pc_rels) {
            if(this.briscole.includes(this.player_game_rel)) {
                var i = 0;
                var min_value = 100;
                for (i = 0; i < pc_rels_core.length; i++) {
                    if (!this.briscole.includes(pc_rels_core[i])) {
                        if (this.real_value_card(pc_rels_core[i]) < min_value) {
                            min_value = this.real_value_card(pc_rels_core[i]);
                        }
                    }
                }
                if(min_value == 100) {
                    var i = 0;
                    var min_value = 100;
                    for (i = 0; i < pc_rels_core.length; i++) {
                        if (this.real_value_card(pc_rels_core[i]) < min_value) {
                            min_value = this.real_value_card(pc_rels_core[i]);
                        }
                    }
                    for (i = 0; i < pc_rels_core.length; i++) {
                        if (this.real_value_card(pc_rels_core[i]) == min_value) {
                            this.pc_position_invisible_true(pc_rels, String(pc_rels_core[i]));
                            this.pc_game_invisible_false(String(pc_rels_core[i]));
                            //alert('move briscola lower');
                            return true;
                        }
                    }
                } else {
                    var i = 0;
                    for (i = 0; i < pc_rels_core.length; i++) {
                        if (this.real_value_card(pc_rels_core[i]) == min_value) {
                            this.pc_position_invisible_true(pc_rels, String(pc_rels_core[i]));
                            this.pc_game_invisible_false(String(pc_rels_core[i]));
                            //alert('move different sign loose');
                            return true;
                        }
                    }
                }
            } else {
                var arr_real_values = [this.real_value_card(pc_rels_core[0]),this.real_value_card(pc_rels_core[1]),this.real_value_card(pc_rels_core[2])];
                arr_real_values.sort(function(a, b) {
                    return a - b;
                });
                var sign_card_game = this.find_sign(this.player_game_rel);
                var i = 0;
                var z = 0;
                for (i = 0; i < arr_real_values.length; i++) {
                    for (z = 0; z < pc_rels_core.length; z++) {
                        if (arr_real_values[i] == this.real_value_card(pc_rels_core[z]) && !this.briscole.includes(pc_rels_core[z]) ) {
                            if (sign_card_game == this.find_sign(pc_rels_core[z])  ) {
                                if (parseInt(pc_rels_core[z]) < parseInt(this.player_game_rel) ) {
                                    this.pc_position_invisible_true(pc_rels, String(pc_rels_core[z]));
                                    this.pc_game_invisible_false(String(pc_rels_core[z]));
                                    //alert('move same sign lower loose');
                                    return true;
                                }
                            } else {
                                this.pc_position_invisible_true(pc_rels, String(pc_rels_core[z]));
                                this.pc_game_invisible_false(String(pc_rels_core[z]));
                                //alert('move different sign loose');
                                return true;
                            }
                        }
                    }
                }
            }
        },
        /*move_win_last_round(pc_rels_core, pc_rels) {
            if(this.briscole.includes(this.player_game_rel)) {

            } else {
                
            }
        },*/
        move_against_scartella(pc_rels_core, pc_rels) {
            if (this.scartelle.includes(this.player_game_rel)) {
                //alert('move against scartella');
                if (this.move_same_sign(pc_rels_core, pc_rels)) {
                    return true;
                } else if (this.move_scartella_different(pc_rels)) {
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    return true;
                } else if (this.move_scartella(pc_rels)) {
                    return true;
                } else if (this.move_re(pc_rels)) {
                    return true;
                } else if (this.move_briscola(pc_rels)) {
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        move_against_punti(pc_rels_core, pc_rels) {
            if (this.punti.includes(this.player_game_rel)) {
                //alert('move against punti');
                if (this.move_same_higher(pc_rels_core, pc_rels)) {
                    return true;
                } else if (this.move_briscola_little(pc_rels)) {
                    return true;
                } else if (this.move_scartella(pc_rels)) {
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    return true;
                } else if (this.move_re(pc_rels)) {
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        move_against_asso(pc_rels_core, pc_rels) {
            if (this.assi.includes(this.player_game_rel)) {
                //alert('move against asso');
                if (this.move_briscola(pc_rels)) {
                    return true;
                } else if (this.move_scartella(pc_rels)) {
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    return true;
                } else if (this.move_re(pc_rels)) {
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        move_against_tre(pc_rels_core, pc_rels) {
            if (this.tre.includes(this.player_game_rel)) {
                //alert('move against tre');
                if (this.move_same_higher(pc_rels_core, pc_rels)) {
                    return true;
                } else if (this.move_briscola(pc_rels)) {
                    return true;
                } else if (this.move_scartella(pc_rels)) {
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    return true;
                } else if (this.move_re(pc_rels)) {
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        move_same_sign(pc_rels_core, pc_rels) {
            if (!this.briscole.includes(this.player_game_rel) && !this.assi.includes(this.player_game_rel)) {
                var sign_card = this.find_sign(this.player_game_rel);
                var higher_same_arr = this.find_same_higher(this.player_game_rel, sign_card);
                var lower_same_arr = this.find_same_lower(this.player_game_rel, sign_card);
                var i = 0;
                for (i = higher_same_arr.length - 1; i >= 0; i--) {
                    if (higher_same_arr[i] > parseInt(this.player_game_rel) && pc_rels_core.includes(String(higher_same_arr[i])) && !this.scartelle.includes(String(higher_same_arr[i]))) {
                        this.pc_position_invisible_true(pc_rels, String(higher_same_arr[i]));
                        this.pc_game_invisible_false(String(higher_same_arr[i]));
                        //alert('scartella against same sign punti');
                        return true;
                    }
                }
                for (i = lower_same_arr.length - 1; i >= 0; i--) {
                    if (lower_same_arr[i] < parseInt(this.player_game_rel) && pc_rels_core.includes(String(lower_same_arr[i])) && this.scartelle.includes(String(lower_same_arr[i]))) {
                        this.pc_position_invisible_true(pc_rels, String(lower_same_arr[i]));
                        this.pc_game_invisible_false(String(lower_same_arr[i]));
                        //alert('scartella against same sign scartella lower');
                        return true;
                    }
                }
            }
            
        },
        move_same_higher(pc_rels_core, pc_rels) {
            if (!this.briscole.includes(this.player_game_rel) && !this.assi.includes(this.player_game_rel)) {
                var sign_card = this.find_sign(this.player_game_rel);
                var higher_same_arr = this.find_same_higher(this.player_game_rel, sign_card);
                var i = 0;
                for (i = higher_same_arr.length - 1; i >= 0; i--) {
                    if (higher_same_arr[i] > parseInt(this.player_game_rel) && pc_rels_core.includes(String(higher_same_arr[i]))) {
                        this.pc_position_invisible_true(pc_rels, String(higher_same_arr[i]));
                        this.pc_game_invisible_false(String(higher_same_arr[i]));
                        //alert('card against higher same sign');
                        return true;
                    }
                }
            }
            
        },
        find_same_higher (card, sign_card) {
            var arr_higher = [];
            var max_num = 0;
            var min_num = 0;
            switch (sign_card) {
                case 1:
                    max_num = 10;
                    min_num = 1;
                    break;
                case 2:
                    max_num = 20;
                    min_num = 11;
                    break;
                case 3:
                    max_num = 30;
                    min_num = 21;
                    break;
                case 4:
                    max_num = 40;
                    min_num = 31;
                    break;
            }
            var i = 0;
            
            for (i = min_num; i <= max_num; i++) {
                if (i > parseInt(card)) {
                    arr_higher.push(i);
                }
            }
            return arr_higher;
        },
        find_same_lower (card, sign_card) {
            var arr_lower = [];
            var max_num = 0;
            var min_num = 0;
            switch (sign_card) {
                case 1:
                    max_num = 10;
                    min_num = 1;
                    break;
                case 2:
                    max_num = 20;
                    min_num = 11;
                    break;
                case 3:
                    max_num = 30;
                    min_num = 21;
                    break;
                case 4:
                    max_num = 40;
                    min_num = 31;
                    break;
            }
            var i = 0;
            
            for (i = min_num; i <= max_num; i++) {
                if (i < parseInt(card)) {
                    arr_lower.push(i);
                }
            }
            return arr_lower;
        },
        find_sign(card) {
            var card_num = parseInt(card);
            var sign_card = 0;
            if (card_num <=10) {
                sign_card = 1;
            } else if (card_num > 10 && card_num <= 20) {
                sign_card = 2;
            } else if (card_num > 20 && card_num <= 30) {
                sign_card = 3;
            } else {
                sign_card = 4;
            }
            return sign_card;
        },
        move_against_briscola_little(pc_rels_core, pc_rels) {
            //alert("move_against_briscola_little");
            if (this.briscole.includes(this.player_game_rel)) {
                if (this.move_scartella(pc_rels)) {
                    //alert("move_scartella");
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    //alert("move_fante");
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    //alert("move_cavallo");
                    return true;
                } else if (this.move_re(pc_rels)) {
                    //alert("move_re");
                    return true;
                //} else if (this.move_briscola(pc_rels)) {
                } else if (this.move_lowest_briscola(pc_rels)) {
                    //alert("move_lowest_briscola"); //move_lowest_briscola (pc_rels)
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    //alert("move_tre");
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    //alert("move_asso");
                    return true;
                } else {
                    return false;
                }
            }
        },
        move_briscola (pc_rels) {
            var briscole_array = [];
            var i = 0;
            var briscole_checker = false;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.briscole.includes(pc_rel_invisible[1])) {
                    briscole_array.push(pc_rel_invisible[1]);
                    briscole_checker = true;
                }
            }
            if (briscole_checker === true) {
                briscole_array.sort();
                if(briscole_array.length > 1 && briscole_array[0].length > 1) {
                    this.pc_position_invisible_true(pc_rels, briscole_array[1]);
                    this.pc_game_invisible_false(briscole_array[1]);
                } else {
                    this.pc_position_invisible_true(pc_rels, briscole_array[0]);
                    this.pc_game_invisible_false(briscole_array[0]);
                }
                //alert(briscole_array);
                //alert('briscola against briscola lower');
                return true;
            }
        },
        move_briscola_little (pc_rels) {
            var briscole_array = [];
            var i = 0;
            var briscole_checker = false;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.briscole.includes(pc_rel_invisible[1])) {
                    briscole_array.push(pc_rel_invisible[1]);
                    briscole_checker = true;
                }
            }
            if (briscole_checker === true) {
                briscole_array.sort();
                if (!this.tre.includes(briscole_array[0]) && !this.assi.includes(briscole_array[0])) {
                    this.pc_position_invisible_true(pc_rels, briscole_array[0]);
                    this.pc_game_invisible_false(briscole_array[0]);
                    //alert(briscole_array);
                    //alert('punti against briscola little');
                    return true;
                }
                
            }
        },
        move_against_briscola_tre(pc_rels_core, pc_rels) {
            if (this.briscole.includes(this.player_game_rel)) {
                var check_asso_briscola = String(parseInt(this.player_game_rel) + 1);
                if (this.tre.includes(this.player_game_rel) && pc_rels_core.includes(check_asso_briscola)) {
                    
                    this.pc_position_invisible_true(pc_rels, check_asso_briscola);
                    this.pc_game_invisible_false(check_asso_briscola);
                    //alert('asso briscola against tre briscola')
                    return true;
                }
            }
        },
        move_scartella_different (pc_rels) {
            var i = 0;
            var sign_card = this.find_sign(this.player_game_rel);
            var same_arr = this.find_cards_sign(sign_card);
            //alert(same_arr);
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.scartelle.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1]) && !same_arr.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('scartella against scartella different');
                    return true;
                }
            }
        },
        move_fante_different (pc_rels) {
            var i = 0;
            var sign_card = this.find_sign(this.player_game_rel);
            var same_arr = this.find_cards_sign(sign_card);
            //alert(same_arr);
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.fanti.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1]) && !same_arr.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('scartella against scartella different');
                    return true;
                }
            }
        },
        move_cavallo_different (pc_rels) {
            var i = 0;
            var sign_card = this.find_sign(this.player_game_rel);
            var same_arr = this.find_cards_sign(sign_card);
            //alert(same_arr);
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.cavalli.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1]) && !same_arr.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('scartella against scartella different');
                    return true;
                }
            }
        },
        move_re_different (pc_rels) {
            var i = 0;
            var sign_card = this.find_sign(this.player_game_rel);
            var same_arr = this.find_cards_sign(sign_card);
            //alert(same_arr);
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.re.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1]) && !same_arr.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('scartella against scartella different');
                    return true;
                }
            }
        },
        find_cards_sign(card_sign) {
            var cards_same_arr = [];
            switch (card_sign) {
                case 1:
                    cards_same_arr = this.bastoni;
                    break;
                case 2:
                    cards_same_arr = this.spade;
                    break;
                case 3:
                    cards_same_arr = this.denari;
                    break;
                case 4:
                    cards_same_arr = this.coppe;
                    break;
            }
            return cards_same_arr;
        },
        move_scartella (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.scartelle.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against scartella')
                    return true;
                }
            }
        },
        move_fante (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.fanti.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against fante')
                    return true;
                }
            }
        },
        move_cavallo (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.cavalli.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against cavallo')
                    return true;
                }
            }
        },
        move_re (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.re.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against re')
                    return true;
                }
            }
        },
        move_lowest_briscola (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (!this.assi.includes(pc_rel_invisible[1]) && !this.tre.includes(pc_rel_invisible[1]) && this.briscole.includes(pc_rel_invisible[1])) {
                    var briscole_array = [];
                    var z = 0;
                    for (z = 0; z < pc_rels.length; z++) {
                        var card_rel = pc_rels[z];
                        var pc_rel_invisible = card_rel.split("_");
                        if (!this.assi.includes(pc_rel_invisible[1]) && !this.tre.includes(pc_rel_invisible[1]) && this.briscole.includes(pc_rel_invisible[1])) {
                            briscole_array.push(pc_rel_invisible[1]);
                        }
                    }
                    briscole_array.sort();
                    this.pc_position_invisible_true(pc_rels, briscole_array[0]);
                    this.pc_game_invisible_false(briscole_array[0]);
                    //alert('asso briscola against briscola');
                    return true;
                }
            }
        },
        move_tre (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.tre.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against tre')
                    return true;
                }
            }
        },
        move_asso (pc_rels) {
            var i = 0;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (this.assi.includes(pc_rel_invisible[1]) && !this.briscole.includes(pc_rel_invisible[1])) {
                    this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
                    this.pc_game_invisible_false(pc_rel_invisible[1]);
                    //alert('asso briscola against asso')
                    return true;
                }
            }
        },
        move_against_briscola_asso(pc_rels_core, pc_rels) {
            if (this.briscole.includes(this.player_game_rel) && this.assi.includes(this.player_game_rel)) {
                if (this.move_scartella(pc_rels)) {
                    return true;
                } else if (this.move_fante(pc_rels)) {
                    return true;
                } else if (this.move_cavallo(pc_rels)) {
                    return true;
                } else if (this.move_re(pc_rels)) {
                    return true;
                } else if (this.move_lowest_briscola(pc_rels)) {
                    return true;
                } else if (this.move_tre(pc_rels)) {
                    return true;
                } else if (this.move_asso(pc_rels)) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        pc_position_invisible_true (pc_rels, invisible_card) {
            var i;
            for (i = 0; i < pc_rels.length; i++) {
                var card_rel = pc_rels[i];
                var pc_rel_invisible = card_rel.split("_");
                if (pc_rel_invisible[1] === invisible_card) {
                    if (pc_rel_invisible[0] === '0') {
                        this.pc_left_invisible = true;
                    } else if (pc_rel_invisible[0] === '1') {
                        this.pc_center_invisible = true;
                    } else {
                        this.pc_right_invisible = true;
                    }
                }
            }
        },
        pc_game_invisible_false (visible_card) {
            var src_image = this.num_to_src(visible_card);
            this.pc_game_src = src_image;
            this.pc_game_rel = visible_card;
            this.pc_game_invisible = false;
        },
        random_answer_pc(pc_rels) {
            //alert('random answer');
            var arr_len = pc_rels.length;
            var arr_num = Math.floor(Math.random() * arr_len);
            var pc_arr_invisible = pc_rels[arr_num];
            
            var pc_rel_invisible = pc_arr_invisible.split("_");
            this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
            this.pc_game_invisible_false(pc_rel_invisible[1]);
        },
        compare_cards() {
            if ((10 - this.game_briscola_rel < 10) && (10 - this.game_briscola_rel >= 0)) {
                this.who_win(10);
            } else if ((20 - this.game_briscola_rel < 10) && (20 - this.game_briscola_rel >= 0)) {
                this.who_win(20);
            } else if ((30 - this.game_briscola_rel < 10) && (30 - this.game_briscola_rel >= 0)) {
                this.who_win(30);
            } else {
                this.who_win(40);
            }
        },
        
        who_win(card_sign) {
            if (((10 - this.player_game_rel < 10) && (10 - this.player_game_rel >= 0)) && ((10 - this.pc_game_rel < 10) && (10 - this.pc_game_rel >= 0)) || ((20 - this.player_game_rel < 10) && (20 - this.player_game_rel >= 0)) && ((20 - this.pc_game_rel < 10) && (20 - this.pc_game_rel >= 0)) || ((30 - this.player_game_rel < 10) && (30 - this.player_game_rel >= 0)) && ((30 - this.pc_game_rel < 10) && (30 - this.pc_game_rel >= 0)) || ((40 - this.player_game_rel < 10) && (40 - this.player_game_rel >= 0)) && ((40 - this.pc_game_rel < 10) && (40 - this.pc_game_rel >= 0)) ) {
                if (parseInt(this.player_game_rel) > parseInt(this.pc_game_rel)) {
                    this.player_cards.push(this.player_game_rel);
                    this.player_cards.push(this.pc_game_rel);
                    this.player_start = true;
                    this.sum_points("player", this.player_game_rel, this.pc_game_rel);
                    //this.nav_comment = "Nice move!";
                    this.nav_comment = this.positive_nav_comment();
                    setTimeout(() => { this.played_cards_invisible(); }, 3000);
                    
                } else {
                    this.pc_cards.push(this.player_game_rel);
                    this.pc_cards.push(this.pc_game_rel);
                    this.player_start = false;
                    this.sum_points("pc", this.player_game_rel, this.pc_game_rel);
                    //this.nav_comment = "Oh nooooo!";
                    this.nav_comment = this.negative_nav_comment();
                    setTimeout(() => { this.played_cards_invisible(); }, 3000);
                    
                }
            } else if (((card_sign - this.player_game_rel < 10) && (card_sign - this.player_game_rel >= 0)) && !((card_sign - this.pc_game_rel < 10) && (card_sign - this.pc_game_rel >= 0))) {
                this.player_cards.push(this.player_game_rel);
                this.player_cards.push(this.pc_game_rel);
                this.player_start = true;
                //this.nav_comment = "Nice move!";
                this.nav_comment = this.positive_nav_comment();
                this.sum_points("player", this.player_game_rel, this.pc_game_rel);
                setTimeout(() => { this.played_cards_invisible(); }, 3000);
            } else if (!((card_sign - this.player_game_rel < 10) && (card_sign - this.player_game_rel >= 0)) && ((card_sign - this.pc_game_rel < 10) && (card_sign - this.pc_game_rel >= 0))) {
                this.pc_cards.push(this.player_game_rel);
                this.pc_cards.push(this.pc_game_rel);
                this.player_start = false;
                //this.nav_comment = "Oh nooooo!";
                this.nav_comment = this.negative_nav_comment();
                this.sum_points("pc", this.player_game_rel, this.pc_game_rel);
                setTimeout(() => { this.played_cards_invisible(); }, 3000);
            } else {
                if(this.player_start) {
                    this.player_cards.push(this.player_game_rel);
                    this.player_cards.push(this.pc_game_rel);
                    this.player_start = true;
                    //this.nav_comment = "Nice move!";
                    this.nav_comment = this.positive_nav_comment();
                    this.sum_points("player", this.player_game_rel, this.pc_game_rel);
                    setTimeout(() => { this.played_cards_invisible(); }, 3000);
                } else {
                    this.pc_cards.push(this.player_game_rel);
                    this.pc_cards.push(this.pc_game_rel);
                    this.player_start = false;
                    //this.nav_comment = "Oh nooooo!";
                    this.nav_comment = this.negative_nav_comment();
                    this.sum_points("pc", this.player_game_rel, this.pc_game_rel);
                    setTimeout(() => { this.played_cards_invisible(); }, 3000);
                    
                }
            }
        },
        positive_nav_comment() {
            /*if (this.remaining_cards == '7' || this.remaining_cards == '6') {
                return 'LAST ROUND';
            }*/
            var nav_comments = ["Nice move!", "Awesome!", ":D", "Are you a master?"];
            var nav_comments_len = nav_comments.length;
            var arr_num = Math.floor(Math.random() * nav_comments_len);
            return nav_comments[arr_num];
        },
        negative_nav_comment() {
            /*if (this.remaining_cards == '7' || this.remaining_cards == '6') {
                return 'LAST ROUND';
            }*/
            var nav_comments = ["Oh nooooo!", ":(", "SOB", "Not a good move man!"];
            var nav_comments_len = nav_comments.length;
            var arr_num = Math.floor(Math.random() * nav_comments_len);
            return nav_comments[arr_num];
        },
        played_cards_invisible() {
            this.player_game_invisible = true;
            this.pc_game_invisible = true;
            this.remove_pc_by_rel(this.player_game_rel);
            this.check_invisible_cards();
            if (this.remaining_cards == '8' || this.remaining_cards == '7') {
                this.nav_comment = "LAST ROUND";
            } else {
                //alert(this.remaining_cards + ' 1')
                this.nav_comment = "Have a nice play!";
            }
            //this.nav_comment = "Have a nice play!";
        },
        check_invisible_cards() {
            if (this.player_start) {
                if(this.player_left_invisible === true) {
                    this.assign_new_card(this.player_left_rel);
                }
                if(this.player_center_invisible === true) {
                    this.assign_new_card(this.player_center_rel);
                }
                if(this.player_right_invisible === true) {
                    this.assign_new_card(this.player_right_rel);
                }
                if(this.pc_left_invisible === true) {
                    this.assign_new_card(this.pc_left_rel);
                    this.remove_pc_by_rel(this.pc_left_rel);
                }
                if(this.pc_center_invisible === true) {
                    this.assign_new_card(this.pc_center_rel);
                    this.remove_pc_by_rel(this.pc_center_rel);
                }
                if(this.pc_right_invisible === true) {
                    this.assign_new_card(this.pc_right_rel);
                    this.remove_pc_by_rel(this.pc_right_rel);
                } 
            } else {
                if(this.pc_left_invisible === true) {
                    this.assign_new_card(this.pc_left_rel);
                    this.remove_pc_by_rel(this.pc_left_rel);
                }
                if(this.pc_center_invisible === true) {
                    this.assign_new_card(this.pc_center_rel);
                    this.remove_pc_by_rel(this.pc_center_rel);
                }
                if(this.pc_right_invisible === true) {
                    this.assign_new_card(this.pc_right_rel);
                    this.remove_pc_by_rel(this.pc_right_rel);
                }
                if(this.player_left_invisible === true) {
                    this.assign_new_card(this.player_left_rel);
                }
                if(this.player_center_invisible === true) {
                    this.assign_new_card(this.player_center_rel);
                }
                if(this.player_right_invisible === true) {
                    this.assign_new_card(this.player_right_rel);
                }
                 
            }
            if (!this.player_start) {
                this.pc_start();
            }
        },
        assign_new_card(invisible_rel) {
            if(this.cards.length > 1) {
                var arr_len = this.cards.length;
                var arr_num = Math.floor(Math.random() * arr_len);
                var src_image = this.num_to_src(this.cards[arr_num]);
                switch (invisible_rel) {
                    case this.player_left_rel:
                        this.player_left_rel = this.cards[arr_num];
                        this.player_left_src = src_image;
                        this.player_left_invisible = false;
                        break;
                    case this.player_center_rel:
                        this.player_center_rel = this.cards[arr_num];
                        this.player_center_src = src_image;
                        this.player_center_invisible = false;
                        break;
                    case this.player_right_rel:
                        this.player_right_rel = this.cards[arr_num];
                        this.player_right_src = src_image;
                        this.player_right_invisible = false;
                        break;
                    case this.pc_left_rel:
                        this.pc_left_rel = this.cards[arr_num];
                        this.pc_left_invisible = false;
                        break;
                    case this.pc_center_rel:
                        this.pc_center_rel = this.cards[arr_num];
                        this.pc_center_invisible = false;
                        break;
                    case this.pc_right_rel:
                        this.pc_right_rel = this.cards[arr_num];
                        this.pc_right_invisible = false;
                        break;
                }
                this.cards.splice(arr_num, 1);
                //this.remaining_cards--;
            } else if (this.cards.length == '1') {
                    var src_image = this.num_to_src(this.cards[0]);
                    switch (invisible_rel) {
                        case this.player_left_rel:
                            this.player_left_rel = this.cards[0];
                            this.player_left_src = src_image;
                            this.player_left_invisible = false;
                            break;
                        case this.player_center_rel:
                            this.player_center_rel = this.cards[0];
                            this.player_center_src = src_image;
                            this.player_center_invisible = false;
                            break;
                        case this.player_right_rel:
                            this.player_right_rel = this.cards[0];
                            this.player_right_src = src_image;
                            this.player_right_invisible = false;
                            break;
                        case this.pc_left_rel:
                            this.pc_left_rel = this.cards[0];
                            this.pc_left_invisible = false;
                            break;
                        case this.pc_center_rel:
                            this.pc_center_rel = this.cards[0];
                            this.pc_center_invisible = false;
                            break;
                        case this.pc_right_rel:
                            this.pc_right_rel = this.cards[0];
                            this.pc_right_invisible = false;
                            break;
                    }
                    this.cards = [];
                    //alert('aaa');
                    //this.remaining_cards = this.remaining_cards - 2;
                } else if (!this.game_briscola_invisible) {
                    var src_image_briscola = this.num_to_src(this.game_briscola_rel);
                    switch (invisible_rel) {
                        case this.player_left_rel:
                            this.player_left_rel = this.game_briscola_rel;
                            this.player_left_src = src_image_briscola;
                            this.player_left_invisible = false;
                            this.pc_cards_seen.push(this.game_briscola_rel);
                            break;
                        case this.player_center_rel:
                            this.player_center_rel = this.game_briscola_rel;
                            this.player_center_src = src_image_briscola;
                            this.player_center_invisible = false;
                            this.pc_cards_seen.push(this.game_briscola_rel);
                            break;
                        case this.player_right_rel:
                            this.player_right_rel = this.game_briscola_rel;
                            this.player_right_src = src_image_briscola;
                            this.player_right_invisible = false;
                            this.pc_cards_seen.push(this.game_briscola_rel);
                            break;
                        case this.pc_left_rel:
                            this.pc_left_rel = this.game_briscola_rel;
                            this.pc_left_invisible = false;
                            break;
                        case this.pc_center_rel:
                            this.pc_center_rel = this.game_briscola_rel;
                            this.pc_center_invisible = false;
                            break;
                        case this.pc_right_rel:
                            this.pc_right_rel = this.game_briscola_rel;
                            this.pc_right_invisible = false;
                            break;
                    }
                    this.game_briscola_invisible = true;
                    this.pack_cards_invisible = true;
                } else {
                }
        },
        sum_points(subject, card_one, card_two) {
            var points = 0;
            points = points + this.add_points(card_one);
            points = points + this.add_points(card_two);
            if(subject == 'player') {
                this.player_points = this.player_points + points;
            } else {
                this.pc_points = this.pc_points + points;
            }
        },
        add_points(card) {
            var points = 0;
            var two_points = ['6', '16', '26', '36'];
            var three_points = ['7', '17', '27', '37'];
            var four_points = ['8', '18', '28', '38'];
            var ten_points = ['9', '19', '29', '39'];
            var eleven_points = ['10', '20', '30', '40'];
            if (two_points.includes(card)) {
                points = points + 2;
            } else if (three_points.includes(card)) {
                points = points + 3;
            } else if (four_points.includes(card)) {
                points = points + 4;
            } else if (ten_points.includes(card)) {
                points = points + 10;
            } else if (eleven_points.includes(card)) {
                points = points + 11;
            } else {
                points = points;
            }
            return points;
        },
        pc_start() {
            this.remaining_cards--;
            /*if (this.remaining_cards == '7' || this.remaining_cards == '6' || this.remaining_cards == '5') {
                this.nav_comment = "LAST ROUND";
            } else {
                //alert(this.remaining_cards + ' 1')
                this.nav_comment = "Have you a nice play!";
            }*/
            //alert(this.remaining_cards);
            var pc_rels = [];
            var pc_rels_core = [];
            if (this.pc_left_invisible !== true) {
                var temp_pc_left = "0_" + this.pc_left_rel;
                pc_rels.push(temp_pc_left);
                pc_rels_core.push(this.pc_left_rel);
            } 
            if (this.pc_center_invisible !== true) {
                var temp_pc_center = "1_" + this.pc_center_rel;
                pc_rels.push(temp_pc_center);
                pc_rels_core.push(this.pc_center_rel);
            } 
            if (this.pc_right_invisible !== true) {
                var temp_pc_right = "2_" + this.pc_right_rel;
                pc_rels.push(temp_pc_right);
                pc_rels_core.push(this.pc_right_rel);
            } 
            if(this.remaining_cards == 7) {
                //this.nav_comment = "LAST ROUND";
                //alert("last round pc start");
                if (this.assi.includes(this.game_briscola_rel) || this.tre.includes(this.game_briscola_rel) || this.highest_by_sign(this.game_briscola_rel)) {
                    if (this.move_asso_start(pc_rels, pc_rels_core)) {
                        //alert("move_asso_start");
                        return;
                    } else if (this.move_tre_highest_start(pc_rels, pc_rels_core)) {
                        //alert("move_tre_highest_start");
                        return;
                    } /*else if (this.move_tre_no_highest_start(pc_rels, pc_rels_core)) {
                        alert("move_tre_no_highest_start");
                        return;
                    }*/ else if (this.move_max_punti_highest_start(pc_rels, pc_rels_core)) {
                        //alert("move_max_punti_highest_start");
                        return;
                    } else if (this.move_max_punti_highest_start(pc_rels, pc_rels_core)) {
                        //alert("move_max_punti_highest_start");
                        return;
                    } else if (this.move_max_punti_start(pc_rels, pc_rels_core)) {
                        //alert("move_max_punti_start");
                        return;
                    } else if (this.move_highest_sign_no_briscola_no_carico_start(pc_rels, pc_rels_core)) {
                        //alert("move_highest_sign_no_briscola_no_carico_start");
                        return;
                    } else if (this.move_scartella_punti_start(pc_rels, pc_rels_core)) {
                        //alert("move_scartella_punti_start");
                        return;
                    } else {
                    }
                } else {
                    if (this.move_max_punti_highest_start(pc_rels, pc_rels_core)) {
                        //alert("move_max_punti_highest_start");
                        return;
                    } else if (this.move_max_punti_start(pc_rels, pc_rels_core)) {
                        //alert("move_max_punti_start");
                        return;
                    } else if (this.move_highest_sign_no_briscola_no_carico_start(pc_rels, pc_rels_core)) {
                        //alert("move_highest_sign_no_briscola_no_carico_start");
                        return;
                    } else if (this.move_scartella_punti_start(pc_rels, pc_rels_core)) {
                        //alert("move_scartella_punti_start");
                        return;
                    } else if (this.move_tre_highest_start(pc_rels, pc_rels_core)) {
                        //alert("move_tre_highest_start");
                        return;
                    } else if (this.move_asso_start(pc_rels, pc_rels_core)) {
                        //alert("move_asso_start");
                        return;
                    }/* else if (this.move_tre_no_highest_start(pc_rels, pc_rels_core)) {
                        alert("move_tre_no_highest_start");
                        return;
                    }*/ else {
                    }
                }
            }  
            if(this.remaining_cards == 5) {
                //alert("move_carico_first_last_start");
                if (this.move_carico_first_last_start(pc_rels, pc_rels_core)) {
                    //alert("move_carico_first_last_start 2");
                    return;
                }
            }  
            //alert("move_carico_first_last_start 3");
            if (this.move_highest_card_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 4");
                return;
            } else if (this.move_highest_sign_no_briscola_no_carico_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 5");
                return;
            } else if (this.move_scartella_punti_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 6");
                return;
            } else if (this.move_briscola_lower_no_carico_no_highest_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 7");
                return;
            } else if (this.move_tre_highest_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 8");
                return;
            } else if (this.move_asso_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 9");
                return;
            } else if (this.move_tre_no_highest_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 10");
                return; 
            } else if (this.move_lowest_briscola (pc_rels)) {
                //alert("move_carico_first_last_start 11");
                return;
            } else if (this.move_briscola_asso_start(pc_rels, pc_rels_core)) {
                //alert("move_carico_first_last_start 12");
                return;
            } else {
                //alert("move_carico_first_last_start 13");
                this.pc_random_start(pc_rels);
            }
            
        },
        move_carico_first_last_start(pc_rels, pc_rels_core) {
            var number_carichi = this.find_carichi_length_no_briscola(pc_rels, pc_rels_core);
            var arr_highest_carichi = this.find_carichi_highest(pc_rels, pc_rels_core);
            var i = 0;
            var player_asso_briscola = false;
            for (i = 0; i < this.pc_cards_seen.length; i++) {
                if (this.briscole.includes(this.pc_cards_seen[i]) && this.assi.includes(this.pc_cards_seen[i])) {
                    player_asso_briscola = true;
                }
            }
            var i = 0;
            var pc_tre_briscola = false;
            var pc_tre_rel = "100";
            for (i = 0; i < pc_rels_core.length; i++) {
                if (this.briscole.includes(pc_rels_core[i]) && this.tre.includes(pc_rels_core[i])) {
                    pc_tre_briscola = true;
                    pc_tre_rel = pc_rels_core[i];
                }
            }
            //if (typeof arr_highest_carichi !== 'undefined') {
            if (number_carichi > 0 && arr_highest_carichi.length > 0) {
                var i = 0;
                //var pc_tre_briscola = false;
                //var pc_tre_rel = "100";
                for (i = 0; i < arr_highest_carichi.length; i++) {
                    if (!this.has_card_lower_no_briscola(arr_highest_carichi[i])) {
                        //alert('carico because too many carichi and also lower')
                        this.pc_position_invisible_true(pc_rels, arr_highest_carichi[i]);
                        this.pc_game_invisible_false(arr_highest_carichi[i]);
                        return true;
                    }
                }
                //alert('carico because too many carichi')
                
                this.pc_position_invisible_true(pc_rels, arr_highest_carichi[0]);
                this.pc_game_invisible_false(arr_highest_carichi[0]);
                return true;
            }
                
            //}
            if(player_asso_briscola && pc_tre_briscola) {
                //if(typeof arr_highest_carichi !== 'undefined') {
                    if (number_carichi > 0 && arr_highest_carichi.length > 0) {
                        //alert('carico because tre against asso briscola')
                        this.pc_position_invisible_true(pc_rels, arr_highest_carichi[0]);
                        this.pc_game_invisible_false(arr_highest_carichi[0]);
                        return true;
                    } else {
                        if(this.move_max_punti_highest_start(pc_rels, pc_rels_core)) {
                            //alert('max punti because tre against asso briscola')
                            return true;
                        }
                    }
                    
                //}
            }
        },
        has_card_lower_no_briscola(card_to_check) {
            var sign_card_to_check = this.find_sign(card_to_check);
            if (!this.briscole.includes(card_to_check) && (this.tre.includes(card_to_check) || this.assi.includes(card_to_check))) {
                var i = 0;
                for (i = 0; i < this.pc_cards_seen.length; i++) {
                    if ((this.find_sign(this.pc_cards_seen[i]) == sign_card_to_check) && (parseInt(this.pc_cards_seen[i]) < parseInt(card_to_check))) {
                        return true;
                    }
                }
            }
            /*var carichi_highest_no_briscola = [];
            var i = 0;
            for (i = 0; i < this.pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && (this.tre.includes(pc_rels_core[i]) || this.assi.includes(pc_rels_core[ii])) && this.highest_by_sign(pc_rels_core[i])) {
                    return true;
                }
            }
            var ii = 0;
            for (ii = 0; ii < this.pc_rels_core.length; ii++) {
                if (!this.briscole.includes(pc_rels_core[ii]) && this.assi.includes(pc_rels_core[ii])) {
                    carichi_highest.push(pc_rels_core[ii]);
                }
            }
            alert(carichi_highest);
            return carichi_highest;*/
        },
        find_carichi_highest(pc_rels, pc_rels_core) {
            //alert(pc_rels_core);
            var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var carichi_highest_arr = [];
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.tre.includes(pc_rels_core[i]) && is_higher_card[i]) {
                    carichi_highest_arr.push(pc_rels_core[i]);
                }
            }
            //alert(carichi_highest_arr);
            var ii = 0;
            for (ii = 0; ii < pc_rels_core.length; ii++) {
                if (!this.briscole.includes(pc_rels_core[ii]) && this.assi.includes(pc_rels_core[ii])) {
                    carichi_highest_arr.push(pc_rels_core[ii]);
                }
            }
            //alert(carichi_highest_arr);
            return carichi_highest_arr;
        },
        find_carichi_length_no_briscola(pc_rels, pc_rels_core) {
            //alert(pc_rels_core);
            var carichi_arr = [];
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && (this.tre.includes(pc_rels_core[i]) || this.assi.includes(pc_rels_core[i]))) {
                    carichi_arr.push(pc_rels_core[i]);
                }
            }
            //alert(carichi_highest_arr);
            /*var ii = 0;
            for (ii = 0; ii < pc_rels_core.length; ii++) {
                if (!this.briscole.includes(pc_rels_core[ii]) && this.assi.includes(pc_rels_core[ii])) {
                    carichi_highest_arr.push(pc_rels_core[ii]);
                }
            }*/
            //alert(carichi_highest_arr);
            //alert(carichi_arr);
            return carichi_arr.length;
        },
        move_max_punti_highest_start(pc_rels, pc_rels_core) {
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.re.includes(pc_rels_core[i]) && this.highest_by_sign(pc_rels_core[i])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[i]);
                    this.pc_game_invisible_false(pc_rels_core[i]);
                    return true;
                }
            }
            var ii = 0;
            for (ii = 0; ii < pc_rels_core.length; ii++) {
                if (!this.briscole.includes(pc_rels_core[ii]) && this.cavalli.includes(pc_rels_core[ii]) && this.highest_by_sign(pc_rels_core[ii])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[ii]);
                    this.pc_game_invisible_false(pc_rels_core[ii]);
                    return true;
                }
            }
            var iii = 0;
            for (iii = 0; iii < pc_rels_core.length; iii++) {
                if (!this.briscole.includes(pc_rels_core[iii]) && this.fanti.includes(pc_rels_core[iii]) && this.highest_by_sign(pc_rels_core[iii])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[iii]);
                    this.pc_game_invisible_false(pc_rels_core[iii]);
                    return true;
                }
            }
        },
        move_max_punti_start(pc_rels, pc_rels_core) {
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.re.includes(pc_rels_core[i])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[i]);
                    this.pc_game_invisible_false(pc_rels_core[i]);
                    return true;
                }
            }
            var ii = 0;
            for (ii = 0; ii < pc_rels_core.length; ii++) {
                if (!this.briscole.includes(pc_rels_core[ii]) && this.cavalli.includes(pc_rels_core[ii])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[ii]);
                    this.pc_game_invisible_false(pc_rels_core[ii]);
                    return true;
                }
            }
            var iii = 0;
            for (iii = 0; iii < pc_rels_core.length; iii++) {
                if (!this.briscole.includes(pc_rels_core[iii]) && this.fanti.includes(pc_rels_core[iii])) {
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[iii]);
                    this.pc_game_invisible_false(pc_rels_core[iii]);
                    return true;
                }
            }
        },
        move_briscola_asso_start(pc_rels, pc_rels_core) {
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (this.briscole.includes(pc_rels_core[i]) && this.assi.includes(pc_rels_core[i])) {
                    //alert('briscola asso');
                    this.pc_position_invisible_true(pc_rels, pc_rels_core[i]);
                    this.pc_game_invisible_false(pc_rels_core[i]);
                    return true;
                }
            }
        },
        move_asso_start(pc_rels, pc_rels_core) {
            var assi_arr = [];
            //var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.assi.includes(pc_rels_core[i])) {
                    assi_arr.push(pc_rels_core[i]);
                }
            }
            if (assi_arr.length > 0) {
                //alert('asso no briscola');
                this.pc_position_invisible_true(pc_rels, assi_arr[0]);
                this.pc_game_invisible_false(assi_arr[0]);
                return true;
            }
        },
        move_tre_no_highest_start(pc_rels, pc_rels_core) {
            var tre_arr = [];
            //var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.tre.includes(pc_rels_core[i])) {
                    tre_arr.push(pc_rels_core[i]);
                }
            }
            if (tre_arr.length > 0) {
                //alert('no highest tre');
                this.pc_position_invisible_true(pc_rels, tre_arr[0]);
                this.pc_game_invisible_false(tre_arr[0]);
                return true;
            }
        },
        move_tre_highest_start(pc_rels, pc_rels_core) {
            var tre_arr = [];
            var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (!this.briscole.includes(pc_rels_core[i]) && this.tre.includes(pc_rels_core[i]) && is_higher_card[i]) {
                    tre_arr.push(pc_rels_core[i]);
                }
            }
            if (tre_arr.length > 0) {
                //alert('highest tre');
                this.pc_position_invisible_true(pc_rels, tre_arr[0]);
                this.pc_game_invisible_false(tre_arr[0]);
                return true;
            }
        },
        move_briscola_lower_no_carico_no_highest_start(pc_rels, pc_rels_core) {
            var briscole_arr = [];
            var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var i = 0;
            for (i = 0; i < pc_rels_core.length; i++) {
                if (this.briscole.includes(pc_rels_core[i]) && !this.tre.includes(pc_rels_core[i]) && !this.assi.includes(pc_rels_core[i]) && !is_higher_card[i]) {
                    briscole_arr.push(pc_rels_core[i]);
                }
            }
            if (briscole_arr.length > 0) {
                briscole_arr = briscole_arr.sort();
                //alert('lower briscola no carico no highest')
                this.pc_position_invisible_true(pc_rels, briscole_arr[0]);
                this.pc_game_invisible_false(briscole_arr[0]);
                return true;
            }
        },
        move_highest_card_start(pc_rels, pc_rels_core) {
            if (!this.check_briscole_presence()) {
                var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
                var i = 0;
                for (i=0; i<=is_higher_card.length-1; i++) {
                    if(is_higher_card[i] && !this.briscole.includes(pc_rels_core[i]) ) {
                        //alert("it's highest by sign no briscole");
                        this.pc_position_invisible_true(pc_rels, pc_rels_core[i]);
                        this.pc_game_invisible_false(pc_rels_core[i]);
                        return true;
                    }
                }
            }
        },
        check_briscole_presence() {
            var i = 0;
            if(this.bastoni.includes(this.game_briscola_rel)) {
                for(i=1; i<11; i++) {
                    var i = String(i);
                    if(this.pc_cards_seen.includes(i)) {
                        //alert('yes briscole bastoni');
                        return true;
                    }
                }
                
            } else if (this.spade.includes(this.game_briscola_rel)) {
                for(i=11; i<21; i++) {
                    var i = String(i);
                    if(this.pc_cards_seen.includes(i)) {
                        //alert('yes briscole spade');
                        return true;
                    }
                }
            } else if (this.denari.includes(this.game_briscola_rel)) {
                for(i=21; i<31; i++) {
                    var i = String(i);
                    if(this.pc_cards_seen.includes(i)) {
                        //alert('yes briscole denari');
                        return true;
                    }
                }
            } else {
                for(i=31; i<41; i++) {
                    var i = String(i);
                    if(this.pc_cards_seen.includes(i)) {
                        //alert('yes briscole coppe');
                        return true;
                    }
                }
            }
        },
        move_highest_sign_no_briscola_no_carico_start(pc_rels, pc_rels_core) {
            var is_higher_card = this.is_highest_card_by_sign(pc_rels_core);
            var i = 0;
            for (i=0; i<=is_higher_card.length-1; i++) {
                if(is_higher_card[i] && !this.briscole.includes(pc_rels_core[i]) && !this.tre.includes(pc_rels_core[i]) && !this.assi.includes(pc_rels_core[i]) ) {
                        //alert("it's highest by sign no carico");
                        this.pc_position_invisible_true(pc_rels, pc_rels_core[i]);
                        this.pc_game_invisible_false(pc_rels_core[i]);
                        return true;
                }
            }
        },
        is_highest_card_by_sign(pc_rels_core) {
            var is_highest_arr = [];
            var i = 0;
            for (i=0; i<=pc_rels_core.length-1; i++) {
                if (this.highest_by_sign(pc_rels_core[i])) {
                    is_highest_arr.push(true);
                } else {
                    is_highest_arr.push(false);
                }

            }
            return is_highest_arr;
        },
        highest_by_sign(card) {
            var sign = this.find_sign(card);
            var i = 0;
            if(sign === 1) {
                for(i = 10; i > 0; i--) {
                    var temp_max = String(i);
                    if(this.pc_cards_seen.includes(temp_max)) {
                        if(parseInt(card) > parseInt(temp_max)) {
                            //var message = card + temp_max;
                            //alert(message);
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else if(sign === 2) {
                for(i = 20; i > 10; i--) {
                    var temp_max = String(i);
                    if(this.pc_cards_seen.includes(temp_max)) {
                        if(parseInt(card) > parseInt(temp_max)) {
                            //var message = card + temp_max;
                            //alert(message);
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else if(sign === 3) {
                for(i = 30; i > 20; i--) {
                    var temp_max = String(i);
                    if(this.pc_cards_seen.includes(temp_max)) {
                        if(parseInt(card) > parseInt(temp_max)) {
                            //var message = card + temp_max;
                            //alert(message);
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                for(i = 40; i > 30; i--) {
                    var temp_max = String(i);
                    if(this.pc_cards_seen.includes(temp_max)) {
                        if(parseInt(card) > parseInt(temp_max)) {
                            //var message = card + temp_max;
                            //alert(message);
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        },
        move_scartella_punti_start(pc_rels, pc_rels_core) {
            if (this.check_scartelle_punti(pc_rels_core)) {
                var scartelle_punti_rel = [];
                var i = 0;
                for (i=0; i<pc_rels_core.length; i++) {
                    if ((this.scartelle.includes(pc_rels_core[i]) || this.punti.includes(pc_rels_core[i])) && !this.briscole.includes(pc_rels_core[i])) {
                        scartelle_punti_rel.push(pc_rels_core[i]);
                    }
                }
                //alert(scartelle_punti_rel);
                var card_play = this.less_carichi_above(scartelle_punti_rel);
                //alert( card_play + '99');
                this.pc_position_invisible_true(pc_rels, card_play);
                this.pc_game_invisible_false(card_play);
                //alert("start scartella or punti");
                return true;
            }
        },
        less_carichi_above(cards_arr) {
            var cards_carichi_ab = this.find_carichi_above(cards_arr);
            //alert(cards_carichi_ab);
            if (cards_carichi_ab.length == '1') {
                return cards_arr[0];
            } else if (cards_carichi_ab.length == '2') {
                if (cards_carichi_ab[0] > cards_carichi_ab[1]) {
                    return cards_arr[1];
                } else if (cards_carichi_ab[1] > cards_carichi_ab[0]) {
                    return cards_arr[0];
                } else {
                    if(this.real_value_card(cards_arr[0]) > this.real_value_card(cards_arr[1])) {
                        return cards_arr[1];
                    } else {
                        return cards_arr[0];
                    }
                }
            } else {
                //alert('tre');
                var rel_card = "";
                var rel_value = 100;
                if(cards_carichi_ab.includes(0)) {
                    //alert('contains 0');
                    var i = 0;
                    for(i=0; i<cards_carichi_ab.length; i++ ) {
                        if(cards_carichi_ab[i] === 0) {
                            //alert(cards_arr);
                            var temp_value = this.real_value_card(cards_arr[i]);
                            if (temp_value < rel_value) {
                                rel_card = cards_arr[i];
                                rel_value = temp_value;
                            }
                        }
                    }
                    return rel_card;
                } else if(cards_carichi_ab.includes(1)) {
                    //alert('contains 1 ok');
                    var i = 0;
                    for(i=0; i<=cards_carichi_ab.length - 1; i++ ) {
                        if(cards_carichi_ab[i] === 1) {
                            //alert(cards_arr);
                            var temp_value = this.real_value_card(cards_arr[i]);
                            if (temp_value < rel_value) {
                                rel_card = cards_arr[i];
                                rel_value = temp_value;
                            }
                        }
                    }
                    return rel_card;
                } else {
                    //alert('contains 2 ok');
                    var i = 0;
                    for(i=0; i<=cards_carichi_ab.length - 1; i++ ) {
                            //alert(cards_arr);
                            var temp_value = this.real_value_card(cards_arr[i]);
                            if (temp_value < rel_value) {
                                rel_card = cards_arr[i];
                                rel_value = temp_value;
                            }
                    }
                    
                    return rel_card;
                }

            }
        },
        find_carichi_above(cards_arr) {
            var cards_arr_temp = [];
            var z = 0;
            for (z=0; z<=cards_arr.length - 1; z++) {
                cards_arr_temp.push(cards_arr[z]);
            }
            var i = 0;
            for (i=0; i<=cards_arr.length - 1; i++) {
                if (this.spade.includes(cards_arr[i])) {
                    if (this.pc_cards_seen.includes('19') && this.pc_cards_seen.includes('20')) {
                        cards_arr_temp[i] = 2;
                    } else if (this.pc_cards_seen.includes('19') || this.pc_cards_seen.includes('20')) {
                        cards_arr_temp[i] = 1;
                    } else {
                        cards_arr_temp[i] = 0;
                    }
                } else if (this.bastoni.includes(cards_arr[i])) {
                    if (this.pc_cards_seen.includes('9') && this.pc_cards_seen.includes('10')) {
                        cards_arr_temp[i] = 2;
                    } else if (this.pc_cards_seen.includes('9') || this.pc_cards_seen.includes('10')) {
                        cards_arr_temp[i] = 1;
                    } else {
                        cards_arr_temp[i] = 0;
                    }
                } else if (this.denari.includes(cards_arr[i])) {
                    if (this.pc_cards_seen.includes('29') && this.pc_cards_seen.includes('30')) {
                        cards_arr_temp[i] = 2;
                    } else if (this.pc_cards_seen.includes('29') || this.pc_cards_seen.includes('30')) {
                        cards_arr_temp[i] = 1;
                    } else {
                        cards_arr_temp[i] = 0;
                    }
                } else {
                    if (this.pc_cards_seen.includes('39') && this.pc_cards_seen.includes('40')) {
                        cards_arr_temp[i] = 2;
                    } else if (this.pc_cards_seen.includes('39') || this.pc_cards_seen.includes('40')) {
                        cards_arr_temp[i] = 1;
                    } else {
                        cards_arr_temp[i] = 0;
                    }
                }
            }
            return cards_arr_temp;
        },
        check_scartelle_punti(pc_rels_core) {
            var i = 0;
            for (i=0; i<pc_rels_core.length; i++) {
                if ((this.scartelle.includes(pc_rels_core[i]) || this.punti.includes(pc_rels_core[i])) && !this.briscole.includes(pc_rels_core[i])) {
                    return true;
                }
            }
        },
        pc_random_start(pc_rels) {
            //alert('random start');
            var arr_len = pc_rels.length;
            var arr_num = Math.floor(Math.random() * arr_len);
            var pc_arr_invisible = pc_rels[arr_num];
            var pc_rel_invisible = pc_arr_invisible.split("_");
            this.pc_position_invisible_true(pc_rels, pc_rel_invisible[1]);
            this.pc_game_invisible_false(pc_rel_invisible[1]);
        },
        num_to_src(number) {
            var src_image = "";
            switch(number) {
                case '1':
                    src_image = "images/duebastoni.png";
                    break;
                case '2':
                    src_image = "images/quattrobastoni.png";
                    break;
                case '3':
                    src_image = "images/cinquebastoni.png";
                    break;
                case '4':
                    src_image = "images/seibastoni.png";
                    break;
                case '5':
                    src_image = "images/settebastoni.png";
                    break;
                case '6':
                    src_image = "images/fantebastoni.png";
                    break;
                case '7':
                    src_image = "images/cavallobastoni.png";
                    break;
                case '8':
                    src_image = "images/rebastoni.png";
                    break;
                case '9':
                    src_image = "images/trebastoni.png";
                    break;
                case '10':
                    src_image = "images/assobastoni.png";
                    break;
                case '11':
                    src_image = "images/duespade.png";
                    break;
                case '12':
                    src_image = "images/quattrospade.png";
                    break;
                case '13':
                    src_image = "images/cinquespade.png";
                    break;
                case '14':
                    src_image = "images/seispade.png";
                    break;
                case '15':
                    src_image = "images/settespade.png";
                    break;
                case '16':
                    src_image = "images/fantespade.png";
                    break;
                case '17':
                    src_image = "images/cavallospade.png";
                    break;
                case '18':
                    src_image = "images/respade.png";
                    break;
                case '19':
                    src_image = "images/trespade.png";
                    break;
                case '20':
                    src_image = "images/assospade.png";
                    break;
                case '21':
                    src_image = "images/duedenari.png";
                    break;
                case '22':
                    src_image = "images/quattrodenari.png";
                    break;
                case '23':
                    src_image = "images/cinquedenari.png";
                    break;
                case '24':
                    src_image = "images/seidenari.png";
                    break;
                case '25':
                    src_image = "images/settedenari.png";
                    break;
                case '26':
                    src_image = "images/fantedenari.png";
                    break;
                case '27':
                    src_image = "images/cavallodenari.png";
                    break;
                case '28':
                    src_image = "images/redenari.png";
                    break;
                case '29':
                    src_image = "images/tredenari.png";
                    break;
                case '30':
                    src_image = "images/assodenari.png";
                    break;
                case '31':
                    src_image = "images/duecoppe.png";
                    break;
                case '32':
                    src_image = "images/quattrocoppe.png";
                    break;
                case '33':
                    src_image = "images/cinquecoppe.png";
                    break;
                case '34':
                    src_image = "images/seicoppe.png";
                    break;
                case '35':
                    src_image = "images/settecoppe.png";
                    break;
                case '36':
                    src_image = "images/fantecoppe.png";
                    break;
                case '37':
                    src_image = "images/cavallocoppe.png";
                    break;
                case '38':
                    src_image = "images/recoppe.png";
                    break;
                case '39':
                    src_image = "images/trecoppe.png";
                    break;
                case '40':
                    src_image = "images/assocoppe.png";
                    break;
                default:
                    var message = 'uncorrect src ' + number;
                    //alert(message);
                }
                return src_image;
        },
        real_value_card(number) {
            var real_value = 0;
            switch(number) {
                case '1':
                    real_value = 1;
                    break;
                case '2':
                    real_value = 5;
                    break;
                case '3':
                    real_value = 9;
                    break;
                case '4':
                    real_value = 13;
                    break;
                case '5':
                    real_value = 17;
                    break;
                case '6':
                    real_value = 21;
                    break;
                case '7':
                    real_value = 25;
                    break;
                case '8':
                    real_value = 29;
                    break;
                case '9':
                    real_value = 33;
                    break;
                case '10':
                    real_value = 37;
                    break;
                case '11':
                    real_value = 2;
                    break;
                case '12':
                    real_value = 6;
                    break;
                case '13':
                    real_value = 10;
                    break;
                case '14':
                    real_value = 14;
                    break;
                case '15':
                    real_value = 18;
                    break;
                case '16':
                    real_value = 22;
                    break;
                case '17':
                    real_value = 26;
                    break;
                case '18':
                    real_value = 30;
                    break;
                case '19':
                    real_value = 34;
                    break;
                case '20':
                    real_value = 38;
                    break;
                case '21':
                    real_value = 3;
                    break;
                case '22':
                    real_value = 7;
                    break;
                case '23':
                    real_value = 11;
                    break;
                case '24':
                    real_value = 15;
                    break;
                case '25':
                    real_value = 19;
                    break;
                case '26':
                    real_value = 23;
                    break;
                case '27':
                    real_value = 27;
                    break;
                case '28':
                    real_value = 31;
                    break;
                case '29':
                    real_value = 35;
                    break;
                case '30':
                    real_value = 39;
                    break;
                case '31':
                    real_value = 4;
                    break;
                case '32':
                    real_value = 8;
                    break;
                case '33':
                    real_value = 12;
                    break;
                case '34':
                    real_value = 16;
                    break;
                case '35':
                    real_value = 20;
                    break;
                case '36':
                    real_value = 24;
                    break;
                case '37':
                    real_value = 28;
                    break;
                case '38':
                    real_value = 32;
                    break;
                case '39':
                    real_value = 36;
                    break;
                case '40':
                    real_value = 40;
                    break;
                default:
                    var message = 'uncorrect real value' + number;
                    //alert(message);
                }
                return real_value;
        },
        assign_win() {
            if(this.player_points > this.pc_points) {
                this.player_win++;
                this.calculate_level_player();
            } else if(this.player_points < this.pc_points) {
                this.pc_win++;
                this.calculate_level_player();
            } else {
                this.player_win++;
                this.pc_win++;
                return;
            }
        },
        change_state_to_three() {
            this.assign_win();
            this.state = '3';
        },
        calculate_level_player() {
            var win_level = this.player_win - this.pc_win;
            //alert(win_level);
            var win_level_human = "so so";
            if (win_level > 5) {
                win_level = 5;
            }
            if (win_level < -5) {
                win_level = -5;
            }
            switch (win_level) {
                case 1:
                    win_level_human = "wisdom";
                    break;
                case 2:
                    win_level_human = "very wisdom";
                    break;
                case 3:
                    win_level_human = "master";
                    break;
                case 4:
                    win_level_human = "evangelist";
                    break;
                case 5:
                    win_level_human = "charismatic leader";
                    break;
                case -1:
                    win_level_human = "unwisdom";
                    break;
                case -2:
                    win_level_human = "very unwisdom";
                    break;
                case -3:
                    win_level_human = "noob";
                    break;
                case -4:
                    win_level_human = "incompetent";
                    break;
                case -5:
                    win_level_human = "the worst";
                    break;
                default:
                    win_level_human = "so so";
            }
            this.level_player = win_level_human;
        },
        match_is_over() {
            if(this.remaining_cards == '0' || this.remaining_cards == '-1') {
                //this.match_finished = true;
                this.remaining_cards = 0;
                //this.calculate_level_player();
                setTimeout(() => { this.change_state_to_three(); }, 3000);
                this.remaining_cards = 40;
            }
        },
        handle_bg_color() {
            if (this.state == '1') {
                this.color_chosen = 'bg_state_1';
                document.body.className = this.color_chosen;
            } else if (this.state == '2') {
                this.color_chosen = 'bg_state_2';
                document.body.className = this.color_chosen;
            } else {
                this.color_chosen = 'bg_state_1';
                document.body.className = this.color_chosen;
            }
        }

    },
    watch: {
        remaining_cards: {
            handler: 'match_is_over',
            immediate: true
        },
        state: {
            handler: 'handle_bg_color',
            immediate: true
        } 
    }
}
</script>

<style scoped>

.card {
    border-radius: 10%;
    height: 23vh;
    width: 18vh;
}

@media screen and (max-height:500px) {
        div.mt-2 { 
            margin-top: 3% !important;
        }
    }

@media screen and (max-height:500px) {
        .card { 
            height: 26vh;
            width: 20vh;
        }
    }

@media screen and (max-height:300px) {
        div.mt-2 { 
            margin-top: 2% !important;
        }
    }

</style>