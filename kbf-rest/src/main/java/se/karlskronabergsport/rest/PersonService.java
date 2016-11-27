package se.karlskronabergsport.rest;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import se.karlskronabergsport.entity.Person;
import se.karlskronabergsport.entity.PersonLess;
import se.karlskronabergsport.util.PersonHelper;
import se.karlskronabergsport.util.RestError;

@Path("person")
public class PersonService {

	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("{socSec}")
	public Response getPerson(@PathParam(value = "socSec") String socSec) throws Exception {
		if(!PersonHelper.validSocialSecurityNumber(socSec)) {
			return Response.serverError().entity(new RestError("Felaktigt personnummer!")).build();
		}
		 
		return Response.ok().entity(new Person("9011031979", "Tobias", "Hansson")).build();
	}

	/**
	 * Only return information about how long the person is valid, no name, payment info or social security number
	 * 
	 * @param socSec
	 * @return
	 */
	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("less/{socSec}")
	public Response getPersonLess(@PathParam(value = "socSec") String socSec) {
		if(!PersonHelper.validSocialSecurityNumber(socSec)) {
			return Response.serverError().entity(new RestError("Felaktigt personnummer!")).build();
		}
		return Response.ok().entity(new PersonLess("2016-12-31", "2016-12-31", 0)).build();
	}
}
