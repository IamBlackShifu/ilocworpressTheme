(function (blocks, element, ServerSideRender, i18n) {
  const labels = { services: 'Services', clients: 'Client carousel', projects: 'Project collection', solutions: 'Solutions', testimonials: 'Testimonials', insights: 'Latest insights', contact: 'Contact Form 7' };
  Object.entries(labels).forEach(([kind, label]) => blocks.registerBlockType('infinity/' + kind, {
    apiVersion: 3, title: i18n.__(label, 'infinity-content'), icon: 'screenoptions', category: 'widgets',
    description: i18n.__('Content is managed in the dashboard. Company contact settings are in the Customizer.', 'infinity-content'),
    supports: { html: false }, edit: function () { return element.createElement(ServerSideRender, { block: 'infinity/' + kind }); }, save: function () { return null; }
  }));
})(wp.blocks, wp.element, wp.serverSideRender, wp.i18n);
