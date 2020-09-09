const fs = require("fs");
const path = require("path");
const archiver = require("archiver");
const pkg = require("../package.json");
const { execSync } = require("child_process");

const execCmd = (cmd) => execSync(cmd, { stdio: "inherit" });

const release = () => {
  console.log(`Releasing ${pkg.name} ${pkg.version}\n`);

  // build production code
  console.log("Build production version of assets");
  execCmd("yarn production");

  if (!fs.existsSync(path.resolve(__dirname, "../releases"))) {
    fs.mkdirSync(path.resolve(__dirname, "../releases"));
  }
  // create a file to stream archive data to.
  const output = fs.createWriteStream(
    path.resolve(__dirname, "../releases", `${pkg.name}-${pkg.version}.zip`)
  );
  const archive = archiver("zip");

  // listen for all archive data to be written
  // 'close' event is fired only when a file descriptor is involved
  output.on("close", () => {
    console.log("\nZipped the release package:");
    console.log(`${archive.pointer()} total bytes`);
  });

  // catch warnings (ie stat failures and other non-blocking errors)
  archive.on("warning", (err) => {
    if (err.code === "ENOENT") {
      console.log(err);
    } else {
      // throw error
      throw err;
    }
  });

  // re-throw fatal errors
  archive.on("error", (err) => {
    throw err;
  });

  console.log("\nStarting .zip archive generation\n");
  // pipe archive data to the file
  archive.pipe(output);

  const files = [
    "CHANGELOG.md",
    "composer.json",
    "composer.lock",
    "functions.php",
    "indico-caritas-app.php",
    "mix-manifest.json",
    "package.json",
    "yarn.lock",
  ];

  for (const file of files) {
    console.log(`Adding ${file} to archive`);
    archive.file(path.resolve(__dirname, "../", file), {
      name: `${pkg.name}/${file}`,
    });
  }

  const directories = [
    "dist",
    "img",
    "lib",
    "templates",
    "templates-admin",
    "templates-widgets",
    "vendor",
  ];
  for (const dir of directories) {
    console.log(`Adding ${dir} to archive`);
    archive.directory(
      path.resolve(__dirname, "../", `${dir}/`),
      `${pkg.name}/${dir}`
    );
  }

  archive.finalize();
};

release();
