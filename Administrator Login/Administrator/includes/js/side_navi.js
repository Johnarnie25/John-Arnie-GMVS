const showMenu = (toggleID, navbarID, bodyID)=>{
    const toggle = document.getElementById(toggleID), 
    sidenavbar = document.getElementById(navbarID), 
    bodypadding = document.getElementById(bodyID)

    if (toggle && sidenavbar){
        toggle.addEventListener('click', ()=>{
            sidenavbar.classList.toggle('expander')

            bodypadding.classList.toggle('body-pd')
        })
    }
}
showMenu('nav-toggle','sideNavbar', 'body-pd')

const linkColor = document.querySelectorAll('.navi_link') 
function colorLink(){
    linkColor.forEach(l=> l.classList.remove('active_side'))
    this.classList.add('active_side')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))
    

const linkCollapse = document.getElementsByClassName('fa-chevron-down')
var i 
for(i=0;i<linkCollapse.length;i++){
    linkCollapse[i].addEventListener('click', function(){
        const collapseMenu = this.nextElementSibling
        collapseMenu.classList.toggle('showCollapse')

        const rotate = collapseMenu.previousElementSibling
        rotate.classList.toggle('rotate')
    })
}


const showMenubttn = (toggleID, navbarID, bodyID)=>{
    const togglebttn = document.getElementById(toggleID), 
    sidenavbar = document.getElementById(navbarID), 
    bodypadding = document.getElementById(bodyID)

    if (togglebttn && sidenavbar){
        togglebttn.addEventListener('click', function(){
            sidenavbar.classList.toggle('expander')
            bodypadding.classList.toggle('body-pd')
        })
    }
}
showMenubttn('main_list','sideNavbar', 'body-pd')

const showMenubttn1 = (toggleID, navbarID, bodyID)=>{
    const togglebttn = document.getElementById(toggleID), 
    sidenavbar = document.getElementById(navbarID), 
    bodypadding = document.getElementById(bodyID)

    if (togglebttn && sidenavbar){
        togglebttn.addEventListener('click', function(){
            sidenavbar.classList.toggle('expander')
            bodypadding.classList.toggle('body-pd')
        })
    }
}
showMenubttn1('nav-toggle1','sideNavbar', 'body-pd')

const showMenubttn2 = (toggleID, navbarID, bodyID)=>{
    const togglebttn = document.getElementById(toggleID), 
    sidenavbar = document.getElementById(navbarID), 
    bodypadding = document.getElementById(bodyID)

    if (togglebttn && sidenavbar){
        togglebttn.addEventListener('click', function(){
            sidenavbar.classList.toggle('expander')
            bodypadding.classList.toggle('body-pd')
        })
    }
}
showMenubttn2('nav-toggle2','sideNavbar', 'body-pd')



