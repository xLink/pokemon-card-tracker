const Ziggy = {"url":"http:\/\/ptcg.dev.xlink.cybershade.org","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"pages.dashboard":{"uri":"\/","methods":["GET","HEAD"]},"pages.login":{"uri":"login","methods":["POST"]},"pages.logout":{"uri":"logout","methods":["GET","HEAD"]},"pages.register":{"uri":"register","methods":["GET","HEAD"]},"pages.cards.all":{"uri":"cards","methods":["GET","HEAD"]},"pages.cards.random":{"uri":"cards\/random","methods":["GET","HEAD"]},"pages.cards.single":{"uri":"cards\/{card}","methods":["GET","HEAD"],"parameters":["card"]},"pages.decks.all":{"uri":"decks","methods":["GET","HEAD"]},"pages.decks.single":{"uri":"decks\/{deck}","methods":["GET","HEAD"],"parameters":["deck"]},"pages.sets.all":{"uri":"card-sets","methods":["GET","HEAD"]},"pages.sets.single":{"uri":"card-sets\/{set}","methods":["GET","HEAD"],"parameters":["set"],"bindings":{"set":"id"}}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
