// export default async function ({ route, i18n}) {
//   let lang ='';
//   const value = `; ${document.cookie}`;

//   const parts = value.split(`; lang=`);

//   if (parts.length === 2) lang =  parts.pop().split(';').shift();
//   if (lang) {
//     // the lang is pt_BR for example
//     i18n.setLocale(lang);
//   }

//   // i18n.setLocale(lang)
// }

// export default function (context) {
//   // console.log(i18n)
//   const langCookie = context.app.$cookies.get('lang');
//   const currentRouteName = context.route.fullPath;
//   if (langCookie) {
//     let newRouteName = `${langCookie}${currentRouteName}`;
//     console.log(newRouteName);
//     console.log(context.route.fullPath);
//     // context.redirect(newRouteName);
//       // context.app.router.push(newRouteName);
//   }
//   else{
//     context.next();
//   }
  // context.redirect(newRouteName);
    // context.redirect(newRouteName);
    // context.redirect({ name: newRouteName });
  // console.log(langCookie)
  // const currentLang = context.app.$i18n.locale;

  // if (langCookie) {
  //   // Get the name of the current route

  //   // Build the new route name for the chosen language
  //   const newRouteName = `${currentRouteName}_${langCookie}`;

  //   // Navigate to the new route
  //   context.redirect(newRouteName);
  // } else {
  //   // Set the language cookie to the current language
  //   context.app.$cookies.set('lang', currentLang);

  //   // Call the callback function to continue processing the request
  //   context.next();
  // }
// }
