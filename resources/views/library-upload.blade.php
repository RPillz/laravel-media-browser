<div wire:ignore x-data
    x-init="const uppy = new Uppy({
        debug: true,
        autoProceed: true,
        restrictions: {
            maxFileSize: 1000000000,
            maxNumberOfFiles: 1,
            allowedFileTypes: ['image/*'],
        }
    })
    .use(Dashboard, {
        inline: true,
        target: '#drop-media-library'
    })
    ">

    <div id="drop-media-library"></div>

    <div id="progress-media-library"></div>

</div>
